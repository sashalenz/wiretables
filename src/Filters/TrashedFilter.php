<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\View\View;
use Sashalenz\Wireforms\Fields\SelectField;

class TrashedFilter extends Filter
{
    public function renderIt(): View
    {
        return SelectField::make($this->name, $this->title)
            ->size($this->size)
            ->placeholder($this->placeholder)
            ->required()
            ->value($this->value)
            ->options([
                null => __('wiretables::without_trashed'),
                'with' => __('wiretables::with_trashed'),
                'only' => __('wiretables::only_trashed'),
            ])
            ->withAttributes([
                "wire:change" => "addFilter",
            ])
            ->renderIt();
    }
}
