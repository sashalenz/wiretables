<?php

namespace Sashalenz\Wiretables\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Wiretable extends Component
{
    public function render(): View
    {
        return view('wiretables::wiretable');
    }
}
