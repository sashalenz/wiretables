<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Searchable\Filters\DaterangeFilter;
use Sashalenz\Searchable\Filters\MultipleFilter;
use Sashalenz\Wireforms\Components\Fields\DateTime;
use Spatie\QueryBuilder\AllowedFilter;

class DateTimeFilter extends Filter
{
    private bool $time = false;
    private ?string $mode = 'single';

    public function time(): self
    {
        $this->time = true;

        return $this;
    }

    public function mode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public static function daterange(string $name, $internalName = null, string $arrayValueDelimiter = ' to '): AllowedFilter
    {
        return self::custom($name, new DaterangeFilter(), $internalName, $arrayValueDelimiter)->mode('range');
    }

    public static function multiple(string $name, $internalName = null, string $arrayValueDelimiter = ','): AllowedFilter
    {
        return self::custom($name, new MultipleFilter(), $internalName, $arrayValueDelimiter)->mode('multiple');
    }

    public function render(): View
    {
        return DateTime::make(
            name: $this->getName(),
            placeholder: $this->getPlaceholder(),
            showLabel: false,
            value: $this->getValue($this->value),
            allowClear: true,
            mode: $this->mode,
            time: $this->time
        )
            ->withAttributes([
                "wire:change" => "addFilter('$this->name', \$event.target.value)",
                "x-on:update-{$this->getKebabName()}.window" => "reset()"
            ])
            ->render();
    }
}
