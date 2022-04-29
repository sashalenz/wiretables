<?php

namespace Sashalenz\Wiretable\Components\Buttons;

use Illuminate\Contracts\View\View;

final class RestoreButton extends Button
{
    protected ?string $icon = 'save';

    public function render(): View
    {
        return view('wiretable::components.buttons.restore-button');
    }
}
