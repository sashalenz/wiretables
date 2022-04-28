<?php

namespace Sashalenz\Wiretables\Traits;

trait WithSortableColumn
{
    public function updateRowSort($from, $to): void
    {
//        check if order is the same
        if ($from === $to) {
            return;
        }

//        check if model is sortable 'has SortableTrait'
        if (!method_exists($this->model, 'bootSortableTrait')) {
            info('model is not sortable');
            return;
        }

        $orderColumn = $this->getOrderColumn();

//        check if current sort is sortable field
        if ($this->getSortProperty() !== $orderColumn) {
            info("please sort by {$orderColumn}");
            return;
        }

        $newQuery = app($this->model)->buildSortQuery();

        $fromModel = $this->model::find($from);
        $toModel = $this->model::find($to);

        $prepending = $fromModel->{$orderColumn} > $toModel->{$orderColumn};

        $columns = $newQuery
            ->when(
                $prepending,
                fn ($query) => $query
                    ->where($orderColumn, '>=', $toModel->{$orderColumn})
                    ->where($orderColumn, '<', $fromModel->{$orderColumn}),
                fn ($query) => $query
                    ->where($orderColumn, '>', $fromModel->{$orderColumn})
                    ->where($orderColumn, '<', $toModel->{$orderColumn})
            )
            ->ordered()
            ->get()
            ->when(
                $prepending,
                fn ($collection) => $collection->prepend($fromModel),
                fn ($collection) => $collection->push($fromModel)
            );

        $this->model::setNewOrder($columns->pluck('id'), $columns->min($orderColumn));
    }

    public function getOrderColumn()
    {
        return app($this->model)->determineOrderColumnName();
    }


    public function getUseSortProperty(): bool
    {
        if (!method_exists($this, 'updateRowSort')) {
            return false;
        }

        if (!method_exists($this->model, 'bootSortableTrait')) {
            return false;
        }

        return $this->getOrderColumn() === $this->getSortProperty();
    }

    public function moveOrderUp($id): void
    {
        $this->model::find($id)->moveOrderUp();
    }

    public function moveOrderDown($id): void
    {
        $this->model::find($id)->moveOrderDown();
    }
}
