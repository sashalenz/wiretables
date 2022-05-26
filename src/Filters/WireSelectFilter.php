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
    protected ?string $orderBy = null;
    protected ?string $orderDir = null;

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

    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function orderByDesc(string $orderBy): self
    {
        $this->orderBy($orderBy);
        $this->orderDir = 'desc';

        return $this;
    }

    public function render(): View
    {
        $class = ($this->nestedSet)
            ? NestedSetSelect::class
            : WireSelect::class;

        return $class::make(
                name: $this->name,
                placeholder: $this->placeholder,
                showLabel: false,
                value: $this->getValue($this->value),
                model: $this->model,
                searchable: $this->searchable,
                orderBy: $this->orderBy,
                orderDir: $this->orderDir,
                emitUp: 'addFilter'
            )
            ->withAttributes(array_filter([
                "x-on:update-{$this->getKebabName()}.window" => "event => { \$el.querySelectorAll('div[wire\\\\:id]').forEach((el) => window.Livewire.find(el.getAttribute('wire:id')).emitSelf('fillParent', event.detail.value)) }"
            ]))
            ->render();
    }
}
