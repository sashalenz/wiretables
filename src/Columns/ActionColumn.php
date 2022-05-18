<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class ActionColumn extends Column
{
    protected ?int $width = 5;
    private Collection $buttons;

    public function withButtons(Collection $buttons): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function render(): ?View
    {
        return view('wiretables::columns.action-column', [
            'buttons' => $this->buttons,
        ]);
    }
}
