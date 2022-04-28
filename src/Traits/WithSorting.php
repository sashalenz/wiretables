<?php

namespace Sashalenz\Wiretables\Traits;

use Sashalenz\Wiretables\Components\Columns\Column;

trait WithSorting
{
    protected static string $sortKey = 'sort';

    protected function initializeWithSorting(): void
    {
        $this->queryString[self::$sortKey] = ['except' => $this->getDefaultSort()];

        $this->setSort($this->resolveSort());
    }

    protected function resetSort(): void
    {
        $this->setSort($this->getDefaultSort());
    }

    private function resolveSort():? string
    {
        return request()->query(self::$sortKey, $this->getDefaultSort());
    }

    private function setSort($sort): void
    {
        $this->{self::$sortKey} = (string) $sort;
        $this->request()->query->set('sort', (string) $sort);
    }

    private function getAllowedSorts(): array
    {
        return $this->columns()
                ->filter(fn(Column $column) => $column->isSortable())
                ->map(fn(Column $column) => $column->getName())
                ->values()
                ->toArray() ?? [];
    }

    public function sortBy($columnName): void
    {
        // determinate sort by selected column
        $sort = ($this->getSortProperty() !== $columnName) ? $columnName : sprintf('-%s', $columnName);

        // call private function that setting sort
        $this->setSort($sort);

        // reset page if is not first
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getDefaultSort(): string
    {
        return property_exists($this, 'defaultSort')
            ? $this->defaultSort
            : '-' . $this->columns()->first()->getName();
    }

    public function getSortProperty(): string
    {
        return $this->{self::$sortKey};
    }
}
