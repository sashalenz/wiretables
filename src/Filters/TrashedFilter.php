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
            label: $this->title,
            placeholder: $this->placeholder,
            required: true,
            value: $this->value,
            options: [
                null => __('wiretables::without_trashed'),
                'with' => __('wiretables::with_trashed'),
                'only' => __('wiretables::only_trashed'),
            ]
        )
            ->withAttributes([
                "wire:change" => "addFilter",
            ])
            ->render();
//        return SelectField::make($this->name, $this->title)
//            ->size($this->size)
//            ->placeholder($this->placeholder)
//            ->required()
//            ->value($this->value)
//            ->options([
//                null => __('wiretables::without_trashed'),
//                'with' => __('wiretables::with_trashed'),
//                'only' => __('wiretables::only_trashed'),
//            ])
//            ->withAttributes([
//                "wire:change" => "addFilter",
//            ])
//            ->renderIt();
    }
}
