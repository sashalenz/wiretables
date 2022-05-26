<?php

namespace Sashalenz\Wiretables\Traits;

trait HasIcon
{
    protected bool $disableIcon = false;
    protected ?string $icon = null;

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function withoutIcon(): self
    {
        $this->disableIcon = true;

        return $this;
    }

    public function getIcon(): string|null|bool
    {
        if ($this->disableIcon) {
            return false;
        }

        return $this->icon;
    }
}
