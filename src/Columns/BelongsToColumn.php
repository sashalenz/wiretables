<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class BelongsToColumn extends Column
{
    private ?string $icon = null;
    private ?string $route = null;

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function render(): View
    {
        return view('wiretables::columns.belongs-to-column')
            ->with([
                'icon' => $this->icon,
                'route' => $this->route,
            ]);
    }
}
