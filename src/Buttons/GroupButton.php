<?php

namespace Sashalenz\Wiretable\Components\Buttons;

use Closure;
use RuntimeException;

final class GroupButton extends Button
{
    protected array $buttons = [];
    protected ?Closure $routeCallback = null;
    protected ?string $icon = 'heroicon-o-dots-vertical';

    /**
     * @param array $buttons
     * @return $this
     */
    public function buttons(array $buttons): self
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @param $row
     * @return bool
     */
    public function canDisplay($row): bool
    {
        return count($this->buttons) > 0;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('wiretable::components.buttons.group-button');
    }

    /**
     * @param $row
     * @return mixed
     */
    public function renderIt($row)
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
