<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class Boolean extends Column
{
    public function render(): View
    {
        return view('wiretables::columns.boolean');
    }
}
