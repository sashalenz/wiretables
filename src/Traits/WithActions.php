<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Columns\CheckboxColumn;
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

    protected function getCheckboxColumn(): ?CheckboxColumn
    {
        if (! count($this->actions())) {
            return null;
        }

        return CheckboxColumn::make('checkbox');
    }

    protected function actions(): array
    {
        return [];
    }
}
