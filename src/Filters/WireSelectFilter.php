<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\WireSelect;

class WireSelectFilter extends Filter
{
    private ?string $model = null;

    public function model(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function render(): View
    {
        return WireSelect::make(
            name: $this->name,
            placeholder: $this->placeholder,
            showLabel: false,
            value: $this->getValue($this->value),
            model: $this->model,
            emitUp: 'addFilter'
        )
            ->render();
    }
}
