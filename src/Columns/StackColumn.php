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

    public function render(): ?View
    {
        return view('wiretables::columns.stack-column', [
            'columns' => collect($this->columns)
                ->filter(fn ($column) => $column instanceof ColumnContract)
                ->when(
                    ! is_null($this->highlight),
                    fn (Collection $columns) => $columns->each(
                        fn (Column $column) => $column->hasHighlight && $column->highlight($this->highlight)
                    )
                )
            ,
        ]);
    }
}
