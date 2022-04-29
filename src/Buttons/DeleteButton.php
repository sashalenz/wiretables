<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

final class DeleteButton extends Button
{
    protected ?string $icon = 'trash';

    public function render(): View
    {
        return view('wiretables::buttons.delete-button');
    }
}
