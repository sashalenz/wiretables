<?php

namespace Sashalenz\Wiretables\Contracts;

use Illuminate\Contracts\View\View;

interface FilterContract
{
    public function getName(): string;

    public function title(string $title): self;

    public function placeholder(string $placeholder): self;

    public function size(int $size): self;

    public function value(?string $value = null): self;

    public function render(): View;
}
