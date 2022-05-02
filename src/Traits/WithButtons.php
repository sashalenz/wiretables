<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Sashalenz\Wiretables\Buttons\LinkButton;
use Sashalenz\Wiretables\Buttons\ModalButton;
use Sashalenz\Wiretables\Columns\ActionColumn;
use Sashalenz\Wiretables\Modals\DeleteModal;
use Sashalenz\Wiretables\Modals\RestoreModal;

trait WithButtons
{
    use AuthorizesRequests;

    private array $actionButtons = [];
    protected ?string $createButton = null;
    protected ?string $showButton = null;
    protected ?string $editButton = null;

    public function bootWithButtons(): void
    {
//
    }

    protected function can(string $ability, Model $model): bool
    {
        try {
            $this->authorize($ability, $model);

            return true;
        } catch (AuthorizationException) {
            return false;
        }
    }

    private function getButtons(): array
    {
        $buttons = [];

        if ($this->showButton) {
            $buttons[] = LinkButton::make('show')
                ->icon('heroicon-o-eye')
                ->routeUsing(fn ($row) => route($this->showButton, $row))
                ->displayIf(fn ($row) => $this->can('view', $row));
        }

        if ($this->editButton) {
            $buttons[] = ModalButton::make('edit')
                ->icon('heroicon-o-pencil')
                ->modal($this->editButton)
                ->withParams(fn ($row) => [
                    'model' => $row->getKey(),
                ])
                ->displayIf(fn ($row) => $this->can('update', $row));
        }

        $buttons[] = ModalButton::make('delete')
            ->icon('heroicon-o-trash')
            ->modal(DeleteModal::getName())
            ->withParams(fn ($row) => [
                'modelName' => get_class($row),
                'modelId' => $row->getKey(),
            ])
            ->displayIf(fn ($row) => $this->can('delete', $row));

        if (method_exists($this->model, 'bootSoftDeletes')) {
            $buttons[] = ModalButton::make('restore')
                ->icon('heroicon-o-reply')
                ->modal(RestoreModal::getName())
                ->withParams(fn ($row) => [
                    'modelName' => get_class($row),
                    'modelId' => $row->getKey(),
                ])
                ->displayIf(fn ($row) => $this->can('restore', $row));
        }

        return $buttons;
    }

    protected function getActionColumn(): ?ActionColumn
    {
        $buttons = array_merge(
            $this->buttons(),
            $this->getButtons()
        );

        if (! count($buttons)) {
            return null;
        }

        return ActionColumn::make('action')
            ->withButtons($buttons);
    }

    protected function buttons(): array
    {
        return [];
    }
}
