<?php

namespace Sashalenz\Wiretables\Filters;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\Select;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\FiltersTrashed;

class TrashedFilter extends SelectFilter
{
    public static function make(string $name = 'trashed', $internalName = null): AllowedFilter
    {
        return self::trashed($name, $internalName);
    }

    public function getOptions(): array
    {
        return [
            null => __('wiretables::filter.without_trashed'),
            'with' => __('wiretables::filter.with_trashed'),
            'only' => __('wiretables::filter.only_trashed'),
        ];
    }

    public function getPlaceholder(): string
    {
        return __('wiretables::filter.without_trashed');
    }
}
