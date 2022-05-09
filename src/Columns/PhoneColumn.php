<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class PhoneColumn extends Column
{
    public bool $hasHighlight = true;

    public function render(): ?View
    {
        return view('wiretables::columns.phone-column');
    }
}
