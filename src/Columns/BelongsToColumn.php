<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Sashalenz\Wiretables\Traits\HasFilterable;
use Sashalenz\Wiretables\Traits\HasIcon;

class BelongsToColumn extends Column
{
    use HasFilterable;
    use HasIcon;

    protected ?string $route = null;

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

    public function renderIt($row): ?string
    {
        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'data' => $this->hasDisplayCallback()
                    ? $this->display($row)
                    : $row->{$this->getName()},
                'value' => $row->{$this->getName()}?->getKey(),
                'filter' => $this->getFilterableField(),
                'icon' => $this->getIcon(),
                'route' => $this->route,
            ])
            ->render();
    }

    public function render(): View
    {
        return view('wiretables::columns.belongs-to-column');
    }
}
