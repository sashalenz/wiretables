<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class CheckboxColumn extends Column
{
    protected ?int $width = 2;

    public function renderTitle():? string
    {
        return view('wiretables::partials.checkbox-title')
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.checkbox-column');
    }
}
