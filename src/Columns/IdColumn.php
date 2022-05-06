<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class IdColumn extends Column
{
    public bool $hasHighlight = true;

    public function getTitle(): ?string
    {
        return __('wiretables::table.id');
    }

    public function isSortable(): bool
    {
        return true;
    }

    public function render(): ?View
    {
        return null;
    }
}
