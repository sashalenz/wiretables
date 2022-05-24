<?php

namespace Sashalenz\Wiretables\Buttons;

use Illuminate\Contracts\View\View;

class ActionButton extends Button
{
    protected string $action;
    protected array $params = [];

    public function action(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function params(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function render(): View
    {
        return view('wiretables::buttons.action-button')
            ->with([
                'action' => $this->action,
                'params' => $this->params ?? []
            ]);
    }
}
