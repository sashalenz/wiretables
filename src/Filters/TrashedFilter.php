<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\Select;

class TrashedFilter extends Filter
{
    public function render(): View
    {
        return Select::make(
            name: $this->name,
            placeholder: __('wiretables::filter.without_trashed'),
            showLabel: false,
            value: $this->getValue($this->value),
            options: [
                null => __('wiretables::filter.without_trashed'),
                'with' => __('wiretables::filter.with_trashed'),
                'only' => __('wiretables::filter.only_trashed'),
            ]
        )
            ->withAttributes([
                "wire:change" => "addFilter('$this->name', \$event.target.value)",
            ])
            ->render();
    }
}
