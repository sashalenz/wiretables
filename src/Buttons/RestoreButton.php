<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

final class RestoreButton extends Button
{
    protected ?string $icon = 'save';

    public function render(): View
    {
        return view('wiretables::components.buttons.restore-button');
    }
}
