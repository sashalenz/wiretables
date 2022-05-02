<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Contracts\FilterContract;

use Sashalenz\Wiretables\Filters\TrashedFilter;

trait WithFiltering
{
    private Collection $filters;
    protected static string $filterKey = 'filter';

    public function bootWithFiltering(): void
    {
        $queryFilters = $this->resolveFilter();

        $this->filters = ($queryFilters)
            ? $this->expandFilters($queryFilters)
            : collect();

        $this->updateFilters();
    }

    public function queryStringWithFiltering(): array
    {
        return [
            self::$filterKey => ['except' => ''],
        ];
    }

    private function resolveFilter()
    {
        return $this->getRequest()->query(self::$filterKey, '');
    }

    private function updateFilters(): void
    {
        $this->{self::$filterKey} = $this->shrinkFilters($this->filters);

        $this->getRequest()->query->set('filter', $this->filters->toArray());
    }

    private function expandFilters($filters): Collection
    {
        return collect(explode(';', $filters))
            ->mapWithKeys(static function ($filter) {
                if (! str_contains($filter, ':')) {
                    return [$filter => true];
                }

                [$k, $v] = explode(':', $filter);

                return [$k => $v];
            });
    }

    private function shrinkFilters(Collection $filters): string
    {
        return $filters
            ->map(fn ($filter, $key) => implode(':', [$key, $filter]))
            ->implode(';');
    }

    private function getTrashedFilter(): ?TrashedFilter
    {
        if (! method_exists($this->model, 'bootSoftDeletes')) {
            return null;
        }

        return TrashedFilter::trashed()
            ->default(null)
            ->size(1);
    }

    protected function filters(): Collection
    {
        return collect();
    }

    protected function resetFilter(): void
    {
        $this->filters = collect();

        $this->updateFilters();
    }

    public function addFilter($key, $value): void
    {
        $filter = $this->getFiltersProperty()
            ->first(fn (FilterContract $row) => $row->getName() === $key);

        $castedValue = $filter->getValue($value);

        $this->filters->put($filter->getName(), $castedValue);

        $this->filters = $this->filters->filter();

        $this->updateFilters();

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getFiltersProperty(): Collection
    {
        $trashedFilter = $this->getTrashedFilter();

        return $this->filters()
            ->when(
                ! is_null($trashedFilter),
                fn (Collection $rows) => $rows->push($trashedFilter)
            )
            ->each(
                fn (FilterContract $filter) => $filter->value(
                    $this->filters->get($filter->getName())
                )
            );
    }

    public function getFilterProperty(): string
    {
        return $this->{self::$filterKey};
    }
}
