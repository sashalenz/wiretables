<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\Text;

class TextFilter extends Filter
{
    public function render(): View
    {
        return Text::make(
            name: $this->name,
            placeholder: $this->placeholder,
            showLabel: false,
            allowClear: true,
            value: $this->getValue($this->value)
        )
            ->withAttributes([
                "x-on:input.debounce.1s" => "\$wire.addFilter('$this->name', \$event.target.value)",
                "x-on:update-{$this->getKebabName()}.window" => "\$refs.input.value = event.detail.value",
            ])
            ->render();
    }
}
