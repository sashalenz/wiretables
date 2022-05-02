<?php

namespace Sashalenz\Wiretables\Contracts;

use Illuminate\Contracts\View\View;

interface ButtonContract
{
    public function renderIt($row):? View;
}
