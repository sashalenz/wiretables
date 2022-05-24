<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Contracts\ColumnContract;

class StackColumn extends Column
{
    public bool $hasHighlight = true;
    private array $columns = [];

    public function columns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    private function getColumns(): array
    {
        return collect($this->columns)
            ->filter(fn ($column) => $column instanceof ColumnContract)
            ->filter(fn ($column) => $column->canRender)
            ->when(
                ! is_null($this->highlight),
                fn (Collection $columns) => $columns->each(
                    fn (Column $column) => $column->hasHighlight && $column->highlight($this->highlight)
                )
            )
            ->toArray();
    }

    public function renderIt($row): ?string
    {
        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'row' => $row,
                'columns' => $this->getColumns()
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.stack-column');
    }
}
