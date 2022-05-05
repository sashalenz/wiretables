<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class TextColumn extends Column
{
    public bool $hasHighlight = true;

    public function render(): ?View
    {
        return null;
    }
}
