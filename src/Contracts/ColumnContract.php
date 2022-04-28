<?php

namespace Sashalenz\Wiretables\Contracts;

use Illuminate\Contracts\View\View;

interface ColumnContract
{
    public function render(): ?View;
}
