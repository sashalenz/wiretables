<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class Sortable extends Column
{
    public function render(): View
    {
        return view('wiretables::columns.sortable');
    }
}
