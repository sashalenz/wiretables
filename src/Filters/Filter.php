<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Support\Str;
use Sashalenz\Wiretables\Contracts\FilterContract;
use Spatie\QueryBuilder\AllowedFilter;

abstract class Filter extends AllowedFilter implements FilterContract
{
    protected int $size = 6;
    protected ?string $title = null;
    protected ?string $placeholder = null;
    protected ?string $value = null;
    protected bool $fillable = false;

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

    public function isFillable(): bool
    {
        return $this->fillable;
    }

    public function hasValue(): bool
    {
        return !is_null($this->value);
    }

    public function getKebabName(): string
    {
        return Str::of($this->getName())
            ->camel()
            ->kebab()
            ->prepend('filter-')
            ->toString();
    }

    public function getValue(?string $value = null): ?string
    {
        $newValue = method_exists($this, 'castValue')
            ? $this->castValue($value)
            : $value;

        return $newValue !== $this->getDefault() ? $newValue : null;
    }
}
