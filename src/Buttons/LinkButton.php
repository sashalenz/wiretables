<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

class LinkButton extends Button
{
    public function render(): View
    {
        return view('wiretables::buttons.link-button');
    }
}
