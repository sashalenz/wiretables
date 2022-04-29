<?php

namespace Sashalenz\Wiretable\Components\Buttons;

class LinkButton extends Button
{
    protected ?string $target = null;

    public function target(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.link-button')->with([
            'target' => $this->target,
        ]);
    }
}
