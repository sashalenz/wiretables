<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class HasManyColumn extends Column
{
    private ?string $route = null;
    private ?string $filterKey = null;

    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function filterKey(string $filterKey): self
    {
        $this->filterKey = $filterKey;

        return $this;
    }

    public function canDisplay($row): bool
    {
        if (!$row->{$this->getName()}) {
            return false;
        }

        return parent::canDisplay($row);
    }

    public function render(): View
    {
        return view('wiretables::columns.has-many-column')
            ->with([
                'route' => $this->route,
                'filterKey' => $this->filterKey
            ]);
    }
}
