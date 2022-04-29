<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Sashalenz\Wiretables\Columns\ActionColumn;

trait WithButtons
{
    private string $indexView = 'index';
    private string $createView = 'create';
    private string $showView = 'show';
    private string $editView = 'edit';

    private array $actionButtons = [];
    public ?string $createButton = null;

    public function initializeWithButtons(): void
    {
        if (! isset($this->model)) {
            return;
        }

//        $model = app($this->model);

//        if (method_exists($model, 'getRoute') && $model->hasRoute($this->showView)) {
//            $this->actionButtons[] = LinkButton::make($this->showView)
//                ->icon('heroicon-o-eye')
//                ->routeUsing(fn ($row) => route($row->getRoute($this->showView), $row))
//                ->displayIf(fn ($row) => is_null($row->deleted_at));
//        }
//
//        if (method_exists($model, 'getRoute') && $model->hasRoute($this->editView)) {
//            $this->actionButtons[] = ModalButton::make($this->editView)
//                ->icon('heroicon-o-pencil')
//                ->routeUsing(fn ($row) => route($row->getRoute($this->editView), $row))
//                ->displayIf(fn ($row) => is_null($row->deleted_at));
//        }

//        $this->actionButtons[] = DeleteButton::make('delete')
//            ->displayIf(fn ($row) => is_null($row->deleted_at));
//
//        if (method_exists($this->model, 'bootSoftDeletes')) {
//            $this->actionButtons[] = RestoreButton::make('restore')
//                ->displayIf(fn ($row) => !is_null($row->deleted_at));
//        }

//        if (method_exists($model, 'getRoute') && $model->hasRoute($this->createView)) {
//            $this->createButton = $model->getRoute($this->createView);
//        }
    }

    protected function getActionColumn(): ?ActionColumn
    {
        $this->actionButtons = array_merge($this->buttons(), $this->actionButtons);

        if (! count($this->actionButtons)) {
            return null;
        }

        return ActionColumn::make('action')
            ->withButtons($this->actionButtons);
    }

    protected static function getRoute(string $action, Model $model): ?string
    {
        $alias = collect([
            'index' => 'viewAny',
            'show' => 'view',
            'info' => 'view',
            'edit' => 'update',
            'destroy' => 'delete',
        ])
            ->get($action, $action);

        $isAuthorized = (bool) auth('admin')
            ->user()
            ?->can($alias, $model);

        if (! $isAuthorized) {
            return null;
        }

        $routeName = collect([
            'admin',
            defined(get_class($model) . '::PARENT') ? $model::PARENT : null,
            defined(get_class($model) . '::NESTED') ? $model::NESTED : null,
            defined(get_class($model) . '::TITLE') ? $model::TITLE : null,
            $action,
        ])
            ->filter()
            ->implode('.');

        if (! Route::has($routeName)) {
            return null;
        }

        if (defined(get_class($model) . '::NESTED')) {
            $parent = $model->{Str::of($model::NESTED)->singular()->toString()};

            if (! $parent) {
                return null;
            }

            return route($routeName, [
                $parent->getKey(),
                $model->getKey(),
            ]);
        }

        return route($routeName, $model->getKey());
    }

    protected function buttons(): array
    {
        return [];
    }
}
