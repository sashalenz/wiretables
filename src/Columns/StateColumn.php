<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class StateColumn extends Column
{
    public function render(): ?View
    {
        return view('wiretables::columns.state-column');
    }
}
