<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class BelongsToColumn extends Column
{
    protected string|bool|null $icon = null;
    protected ?string $route = null;

    public function icon(string|bool $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function canDisplay($row): bool
    {
        if (! $row->{$this->getName()}) {
            return false;
        }

        return parent::canDisplay($row);
    }

    public function render(): View
    {
        return view('wiretables::columns.belongs-to-column')
            ->with([
                'icon' => $this->icon,
                'route' => $this->route,
            ]);
    }
}
