<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sashalenz\Wiretables\Contracts\FilterContract;

use Sashalenz\Wiretables\Filters\TrashedFilter;

trait WithFiltering
{
    public string $filter = '';
    protected Collection $filters;
    protected static string $filterKey = 'filter';

    public function hydrateWithFiltering(): void
    {
        $this->resolveFilters();
        $this->updateFilters();
    }

    public function mountWithFiltering(): void
    {
        $this->resolveFilters();
        $this->updateFilters();
    }

    public function queryStringWithFiltering(): array
    {
        return [
            'filter' => [
                'except' => '',
                'as' => self::$filterKey,
            ],
        ];
    }

    private function resolveFilters(): void
    {
        $this->filters = $this->expandFilters();
    }

    private function updateFilters(): void
    {
        $this->filter = $this->shrinkFilters();

        $this->getRequest()->query->set(self::$filterKey, $this->filters->toArray());
    }

    private function expandFilters(): Collection
    {
        if (! $this->filter) {
            return collect();
        }

        return Str::of($this->filter)
            ->explode(';')
            ->mapWithKeys(static function ($filter) {
                if (! str_contains($filter, ':')) {
                    return [$filter => true];
                }

                [$k, $v] = explode(':', $filter);

                return [$k => $v];
            });
    }

    private function shrinkFilters(): string
    {
        return $this->filters
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
        $this->allowedFilters
            ->filter(fn (FilterContract $filter) => $filter->isFillable() && $filter->hasValue())
            ->each(fn (FilterContract $filter) => $this->dispatchBrowserEvent('update-' . $filter->getKebabName(), ['value' => null]));

        $this->filters = collect();

        $this->updateFilters();
    }

    public function addFilterOutside($key, $value): void
    {
        $filter = $this->filtersWithTrashed()
            ->first(fn (FilterContract $row) => $row->getName() === $key);

        if (! $filter) {
            return;
        }

        $this->addFilter($key, $value);
        $this->dispatchBrowserEvent('update-' . $filter->getKebabName(), ['value' => $value]);
    }

    public function addFilter($key, $value): void
    {
        $filter = $this->filtersWithTrashed()
            ->first(fn (FilterContract $row) => $row->getName() === $key);

        if (! $filter) {
            return;
        }

        $castedValue = $filter->getValue($value);

        $this->filters = $this->filters
            ->put($filter->getName(), $castedValue)
            ->filter()
            ->unique();

        $this->updateFilters();

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    private function filtersWithTrashed(): Collection
    {
        $trashedFilter = $this->getTrashedFilter();

        return $this->filters()
            ->when(
                ! is_null($trashedFilter),
                fn (Collection $rows) => $rows->push($trashedFilter)
            );
    }

    public function getAllowedFiltersProperty(): Collection
    {
        return $this->filtersWithTrashed()
            ->each(
                fn (FilterContract $filter) => $filter
                    ->value(
                        $this->filters->get($filter->getName())
                    )
            );
    }
}
