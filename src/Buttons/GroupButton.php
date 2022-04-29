<?php

namespace Sashalenz\Wiretables\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use RuntimeException;

final class GroupButton extends Button
{
    protected array $buttons = [];
    protected ?Closure $routeCallback = null;
    protected ?string $icon = 'heroicon-o-dots-vertical';

    public function buttons(array $buttons): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function canDisplay($row): bool
    {
        return count($this->buttons) > 0;
    }

    public function render(): View
    {
        return view('wiretables::components.buttons.group-button');
    }

    public function renderIt($row):? View
    {
        if (! $this->canDisplay($row)) {
            return null;
        }

        if (! $this->getTitle() && ! $this->getIcon()) {
            throw new RuntimeException('Title or Icon must be presented');
        }

        return $this->render()
            ->with([
                'row' => $row,
                'class' => $this->getClass($row),
                'icon' => $this->getIcon(),
                'title' => $this->getTitle(),
                'buttons' => $this->buttons,
            ]);
    }
}
