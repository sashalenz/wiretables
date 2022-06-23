<?php

namespace Sashalenz\Wiretables;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Livewire\Component;
use Sashalenz\Searchable\Filters\SearchFilter;
use Sashalenz\Wiretables\Columns\Column;
use Sashalenz\Wiretables\Contracts\ColumnContract;
use Sashalenz\Wiretables\Contracts\TableContract;
use Sashalenz\Wiretables\Traits\WithPagination;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\QueryBuilderRequest;

abstract class Wiretable extends Component implements TableContract
{
    use WithPagination;

    public ?Model $model = null;
    public bool $withHeader = true;
    public bool $withFooter = true;
    protected $request;

    protected $listeners = [
        '$refresh',
        'resetTable',
        'addFilter',
        'addFilterOutside',
    ];

    public function resetTable(): void
    {
        $this->resetPage();
        if (method_exists($this, 'resetFilter')) {
            $this->resetFilter();
        }
        if (method_exists($this, 'resetSort')) {
            $this->resetSort();
        }
        if (method_exists($this, 'resetSearch')) {
            $this->resetSearch();
        }
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
        return $this->columns()
            ->filter(fn ($column) => $column instanceof ColumnContract)
            ->filter(fn ($column) => $column->canRender)
            ->when(
                method_exists($this, 'bootWithSearching') && $this->search,
                fn (Collection $rows) => $rows->each(
                    fn (Column $column) => $column->highlight($this->search)
                )
            )
            ->when(
                method_exists($this, 'mountWithFiltering') && method_exists($this, 'notFilterable'),
                fn (Collection $rows) => $rows->each(
                    fn (Column $column) => $column->notFilterable()
                )
            )
            ->when(
                method_exists($this, 'mountWithSorting'),
                fn (Collection $rows) => $rows->each(
                    fn (Column $column) => $column->currentSort($this->sort)
                )
            )
            ->when(
                method_exists($this, 'bootWithButtons') && $actionColumn = $this->getActionColumn(),
                fn (Collection $rows) => $rows->push($actionColumn)
            )
            ->when(
                method_exists($this, 'bootWithActions') && $checkboxColumn = $this->getCheckboxColumn(),
                fn (Collection $rows) => $rows->prepend($checkboxColumn)
            );
    }

    public function getDataProperty()
    {
        $builder = QueryBuilder::for($this->query(), $this->getRequest());

        if (method_exists($this, 'mountWithFiltering')) {
            $builder = $builder->allowedFilters(
                $this->allowedFilters->toArray()
            );
        }

        if (method_exists($this, 'mountWithSorting')) {
            $builder = $builder
                ->defaultSort($this->getDefaultSort())
                ->allowedSorts(
                    $this->allowedSorts->toArray()
                );
        }

        if (method_exists($this, 'bootWithSearching') && (! $this->disableSearch && $this->search)) {
            $builder = $builder
                ->tap(
                    new SearchFilter($this->search, $this->strict)
                );
        }

        return $builder
            ->when(
                $this->simplePagination === true,
                fn (Builder $query) => $query->simplePaginate($this->perPage),
                fn (Builder $query) => $query->paginate($this->perPage)->onEachSide(1)
            );
    }

    abstract public function render(): View;

    abstract public function getTitleProperty(): string;

    abstract protected function query(): Builder|Relation;

    abstract protected function columns(): Collection;
}
