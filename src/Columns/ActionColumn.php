<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Contracts\ButtonContract;

class ActionColumn extends Column
{
    protected ?int $width = 5;
    private Collection $buttons;

    public function withButtons(Collection $buttons): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function renderIt($row): ?string
    {
        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'row' => $row,
                'buttons' => $this->buttons
                    ->filter(fn (ButtonContract $button) => $button->canDisplay($row)),
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.action-column');
    }
}
