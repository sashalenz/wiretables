<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class EnumColumn extends Column
{
    public function render(): ?View
    {
        return view('wiretables::columns.enum-column');
    }
}
