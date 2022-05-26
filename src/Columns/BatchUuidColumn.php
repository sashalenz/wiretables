<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Sashalenz\Wiretables\Traits\HasFilterable;
use Sashalenz\Wiretables\Traits\HasIcon;

class BatchUuidColumn extends Column
{
    use HasFilterable;
    use HasIcon;

    public function renderIt($row): ?string
    {
        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'value' => $row->{$this->getName()},
                'icon' => $this->getIcon(),
                'filter' => $this->getFilterableField(),
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.batch-uuid-column');
    }
}
