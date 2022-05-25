<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class BelongsToColumn extends Column
{
    protected string|bool|null $icon = null;
    protected ?string $route = null;
    protected bool $filterable = false;
    protected ?string $filterableField = null;

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

    public function filterable(?string $field = null): self
    {
        $this->filterable = true;
        $this->filterableField = $field;

        return $this;
    }

    public function notFilterable(): self
    {
        $this->filterable = false;
        $this->filterableField = null;

        return $this;
    }

    public function canDisplay($row): bool
    {
        if (! $row->{$this->getName()}) {
            return false;
        }

        return parent::canDisplay($row);
    }

    public function getFilterableField(): ?string
    {
        if (! $this->filterable) {
            return null;
        }

        return $this->filterableField ?? $this->name;
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
                'filter' => $this->getFilterableField(),
                'value' => $row->{$this->getName()}?->getKey(),
                'icon' => $this->icon,
                'route' => $this->route,
            ])
            ->render();
    }

    public function render(): View
    {
        return view('wiretables::columns.belongs-to-column');
    }
}
