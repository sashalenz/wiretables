<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

class LinkButton extends Button
{
    protected ?string $target = null;

    public function target(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function render(): View
    {
        return view('wiretable::buttons.link-button')
            ->with([
                'target' => $this->target,
            ]);
    }
}
