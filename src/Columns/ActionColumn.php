<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class ActionColumn extends Column
{
    private ?int $width = 5;
    private array $buttons = [];

    public function withButtons(array $buttons): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function render(): ?View
    {
        return view('wiretables::columns.action-column', [
            'buttons' => collect($this->buttons)->filter()->toArray(),
        ]);
    }
}
