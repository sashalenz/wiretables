<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class BadgeColumn extends Column
{
    public function render(): ?View
    {
        return view('wiretables::columns.badge-column');
    }
}
