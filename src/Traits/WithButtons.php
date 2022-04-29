<?php

namespace Sashalenz\Wiretables\Traits;

use RuntimeException;
use Sashalenz\Wiretables\Columns\ActionColumn;

//use Sashalenz\Wiretables\Components\Buttons\DeleteButton;
//use Sashalenz\Wiretables\Components\Buttons\LinkButton;
//use Sashalenz\Wiretables\Components\Buttons\ModalButton;
//use Sashalenz\Wiretables\Components\Buttons\RestoreButton;
//use Sashalenz\Wiretables\Components\Columns\ActionColumn;

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
        $this->actionButtons = [];

        if (! isset($this->model)) {
            return;
        }

        $model = app($this->model);

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
        $this->actionButtons = collect($this->buttons())
            ->merge($this->actionButtons);

        if (! $this->actionButtons->count()) {
            return null;
        }

        return ActionColumn::make('action')->withButtons($this->actionButtons);
    }

    protected function buttons(): array
    {
        return [];
    }
}
