<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class CheckboxColumn extends Column
{
    protected ?int $width = 2;

    public function renderTitle(): View
    {
        return view('wiretables::partials.checkbox-title');
    }

    public function render(): ?View
    {
        return view('wiretables::columns.checkbox-column');
    }
}
