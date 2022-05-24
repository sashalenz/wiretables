<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class ImageColumn extends Column
{
    public function renderIt($row): ?string
    {
        if (!method_exists($row, 'getFirstMediaUrl')) {
            return null;
        }

        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'data' => $row->getFirstMediaUrl($this->getName(), $row::THUMBNAIL),
                'alt' => $row->getDisplayName()
            ])
            ->render();
    }

    public function render(): View
    {
        return view('wiretables::columns.image-column');
    }
}
