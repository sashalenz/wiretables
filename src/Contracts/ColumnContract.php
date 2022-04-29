<?php

namespace Sashalenz\Wiretables\Contracts;

use Illuminate\Contracts\View\View;

interface ColumnContract
{
    public function isSortable(): bool;

    public function getName(): string;

    public function render(): ?View;
}
