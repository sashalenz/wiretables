<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\Select;

class SelectFilter extends Filter
{
    private array $options = [];
    private bool $nullable = false;

    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function nullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

//    TODO: add multiple property
    public function render(): View
    {
        return Select::make(
            name: $this->getName(),
            placeholder: $this->getPlaceholder(),
            showLabel: false,
            value: $this->getValue($this->value),
            options: $this->getOptions(),
            nullable: $this->nullable
        )
            ->withAttributes([
                "wire:change" => "addFilter('$this->name', \$event.target.value)",
            ])
            ->render();
    }
}
