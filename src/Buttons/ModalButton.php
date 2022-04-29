<?php

namespace Sashalenz\Wiretable\Components\Buttons;

class ModalButton extends Button
{
    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.modal-button');
    }
}
