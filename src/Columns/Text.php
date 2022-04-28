<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class Text extends Column
{
    protected bool $hasHighlight = true;

    public function render():? View
    {
        return null;
    }
}
