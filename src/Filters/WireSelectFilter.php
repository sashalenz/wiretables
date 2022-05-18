<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\NestedSetSelect;
use Sashalenz\Wireforms\Components\Fields\WireSelect;

class WireSelectFilter extends Filter
{
    private ?string $model = null;
    protected bool $nestedSet = false;
    protected bool $searchable = false;
    protected bool $fillable = true;

    public function model(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function nestedSet(): self
    {
        $this->nestedSet = true;

        return $this;
    }

    public function searchable(): self
    {
        $this->searchable = true;

        return $this;
    }

    public function render(): View
    {
        return ($this->nestedSet)
            ? NestedSetSelect::make(
                name: $this->name,
                placeholder: $this->placeholder,
                showLabel: false,
                value: $this->getValue($this->value),
                model: $this->model,
                searchable: $this->searchable,
                emitUp: 'addFilter'
            )->render()
            : WireSelect::make(
                name: $this->name,
                placeholder: $this->placeholder,
                showLabel: false,
                value: $this->getValue($this->value),
                model: $this->model,
                searchable: $this->searchable,
                emitUp: 'addFilter'
            )->render();
    }
}
