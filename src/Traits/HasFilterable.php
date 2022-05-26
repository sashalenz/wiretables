<?php

namespace Sashalenz\Wiretables\Traits;

trait HasFilterable
{
    protected bool $filterable = false;
    protected ?string $filterableField = null;

    public function filterable(?string $field = null): self
    {
        $this->filterable = true;
        $this->filterableField = $field;

        return $this;
    }

    public function notFilterable(): self
    {
        $this->filterable = false;
        $this->filterableField = null;

        return $this;
    }

    public function getFilterableField(): ?string
    {
        if (! $this->filterable) {
            return null;
        }

        return $this->filterableField ?? $this->name;
    }
}
