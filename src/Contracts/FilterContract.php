<?php

namespace Sashalenz\Wiretables\Contracts;

use Illuminate\View\View;

interface FilterContract
{
    public function getName(): string;

    public function value(string $value): self;

    public function renderIt(): View;
}
