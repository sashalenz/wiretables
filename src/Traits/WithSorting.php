<?php

namespace Sashalenz\Wiretables\Traits;

use Sashalenz\Wiretables\Contracts\ColumnContract;

trait WithSorting
{
    protected static string $sortKey = 'sort';

    public function bootWithSorting(): void
    {
        $this->setSort($this->resolveSort());
    }

    public function queryStringWithSorting(): array
    {
        return [
            self::$sortKey => ['except' => $this->getDefaultSort()]
        ];
    }

    protected function resetSort(): void
    {
        $this->setSort($this->getDefaultSort());
    }

    private function resolveSort(): ?string
    {
        return $this->getRequest()->query(self::$sortKey, $this->getDefaultSort());
    }

    private function setSort($sort): void
    {
        $this->{self::$sortKey} = (string) $sort;

        $this->getRequest()->query->set(self::$sortKey, (string) $sort);
    }

    private function getAllowedSorts(): array
    {
        return $this->columns()
                ->filter(fn (ColumnContract $column) => $column->isSortable())
                ->map(fn (ColumnContract $column) => $column->getSortableField())
                ->values()
                ->toArray() ?? [];
    }

    public function sortBy($columnName): void
    {
        $this->setSort(
            ($this->getSortProperty() !== $columnName)
                ? $columnName
                : sprintf('-%s', $columnName)
        );

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getDefaultSort(): string
    {
        return property_exists($this, 'defaultSort')
            ? $this->defaultSort
            : sprintf('-%s', $this->columns()->first()->getName());
    }

    public function getSortProperty(): string
    {
        return $this->{self::$sortKey};
    }
}
