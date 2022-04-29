<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

class ModalButton extends Button
{
    public function render(): View
    {
        return view('wiretables::components.buttons.modal-button');
    }
}
