<?php

namespace Sashalenz\Wiretables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Sashalenz\Wiretables\Columns\Column;
use Sashalenz\Wiretables\Contracts\TableContract;
use Sashalenz\Wiretables\Filters\SearchFilter;
use Sashalenz\Wiretables\Traits\WithActions;
use Sashalenz\Wiretables\Traits\WithButtons;
use Sashalenz\Wiretables\Traits\WithFiltering;
use Sashalenz\Wiretables\Traits\WithPagination;
use Sashalenz\Wiretables\Traits\WithSearching;
use Sashalenz\Wiretables\Traits\WithSorting;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\QueryBuilderRequest;

abstract class Table extends Component implements TableContract
{
    use WithPagination;
    use WithFiltering;
    use WithSorting;
    use WithSearching;
    use WithButtons;
    use WithActions;

    protected Model $model;
    public ?string $layout = null;
    protected $request;

    protected $listeners = [
        '$refresh',
        'resetTable',
        'addFilter',
    ];

    public function resetTable(): void
    {
        $this->resetPage();
        $this->resetFilter();
        $this->resetSort();
        $this->resetSearch();
    }

    public function getRequest(): QueryBuilderRequest
    {
        if (! $this->request) {
            $this->request = app(QueryBuilderRequest::class);
        }

        return $this->request;
    }

    public function getColumnsProperty(): Collection
    {
        $actionColumn = $this->getActionColumn();
        $checkboxColumn = $this->getCheckboxColumn();

        return $this->columns()
            ->when(
                method_exists($this, 'bootWithSearching') && ! is_null($this->getSearchProperty()),
                fn (Collection $rows) => $rows->each(
                    fn (Column $column) => $column->setHighlight($this->getSearchProperty())
                )
            )
            ->when(
                method_exists($this, 'bootWithSorting') && ! is_null($this->getSortProperty()),
                fn (Collection $rows) => $rows->each(
                    fn (Column $column) => $column->setCurrentSort($this->getSortProperty())
                )
            )
            ->when(
                method_exists($this, 'bootWithButtons') && ! is_null($actionColumn),
                fn (Collection $rows) => $rows->push($actionColumn)
            )
            ->when(
                method_exists($this, 'bootWithActions') && ! is_null($checkboxColumn),
                fn (Collection $rows) => $rows->prepend($checkboxColumn)
            );
    }

    public function getDataProperty()
    {
        $builder = QueryBuilder::for($this->query(), $this->getRequest());

        if (method_exists($this, 'bootWithFiltering')) {
            $builder = $builder->allowedFilters(
                $this->getFiltersProperty()->toArray()
            );
        }

        if (method_exists($this, 'bootWithSorting')) {
            $builder = $builder
                ->defaultSort($this->getDefaultSort())
                ->allowedSorts(...$this->getAllowedSorts());
        }

        return $builder
            ->when(
                method_exists($this, 'bootWithSearching') && ! $this->disableSearch && $this->getSearchProperty(),
                new SearchFilter($this->getSearchProperty())
            )
            ->when(
                $this->simplePagination === true,
                fn (Builder $query) => $query->simplePaginate($this->perPage),
                fn (Builder $query) => $query->paginate($this->perPage)->onEachSide(1)
            );
    }

    public function render()
    {
        return view('wiretables::table')
            ->extends(
                $this->layout ?? config('wiretables.layout'),
                ['title' => $this->getTitleProperty()]
            );
    }

    abstract public function getTitleProperty(): string;

    abstract protected function query(): Builder;

    abstract protected function columns(): Collection;
}
