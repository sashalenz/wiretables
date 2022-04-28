<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Columns\Checkbox;
use Sashalenz\Wiretables\Contracts\ActionContract;

trait WithActions
{
    public function getActionsProperty(): Collection
    {
        return collect($this->actions())
            ->each(
                fn (ActionContract $action) => $action->setModel($this->model)
            );
    }

    protected function getCheckboxColumn(): ?Checkbox
    {
        if (! count($this->actions())) {
            return null;
        }

        return Checkbox::make('checkbox');
    }

    protected function actions(): array
    {
        return [];
    }
}
