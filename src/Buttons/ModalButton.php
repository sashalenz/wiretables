<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

class ModalButton extends Button
{
    protected string $modal;

    public function modal(string $modal): self
    {
        $this->modal = $modal;

        return $this;
    }

    public function render(): View
    {
        return view('wiretables::buttons.modal-button')
            ->with([
                'modal' => $this->modal,
            ]);
    }
}
