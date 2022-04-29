<?php

namespace Sashalenz\Wiretables\Filters;

use Sashalenz\Wiretables\Contracts\FilterContract;
use Spatie\QueryBuilder\AllowedFilter;

abstract class Filter extends AllowedFilter implements FilterContract
{
    protected int $size = 6;
    protected ?string $title = null;
    protected ?string $placeholder = null;
    protected ?string $value = null;

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function value(?string $value = null): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(?string $value = null): ?string
    {
        $newValue = method_exists($this, 'castValue')
            ? $this->castValue($value)
            : $value;

        return $newValue !== $this->getDefault() ? $newValue : null;
    }
}
