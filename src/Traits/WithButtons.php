<?php

namespace Sashalenz\Wiretables\Traits;

use Sashalenz\Wiretables\Columns\Action;

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

        if (method_exists($model, 'getRoute') && $model->hasRoute($this->createView)) {
            $this->createButton = $model->getRoute($this->createView);
        }
    }

    public function delete($id): void
    {
        try {
            $model = $this->model::findOrFail($id);
            $model->delete();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => 'Successfully deleted!',
            ]);

            $this->dispatchBrowserEvent('$refresh');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'fail',
                'message' => 'Unable to delete!',
            ]);
        }
    }

    public function restore($id): void
    {
        try {
            $model = $this->model::withTrashed()->findOrFail($id);
            $model->restore();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => 'Successfully restored!',
            ]);

            $this->dispatchBrowserEvent('$refresh');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'fail',
                'message' => 'Unable to restore!',
            ]);
        }
    }

    protected function getActionColumn(): ?Action
    {
        $this->actionButtons = collect($this->buttons())
            ->merge($this->actionButtons);

        if (! $this->actionButtons->count()) {
            return null;
        }

        return Action::make('action')->withButtons($this->actionButtons);
    }

    protected function buttons(): array
    {
        return [];
    }
}
