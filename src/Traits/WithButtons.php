<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Buttons\LinkButton;
use Sashalenz\Wiretables\Buttons\ModalButton;
use Sashalenz\Wiretables\Columns\ActionColumn;
use Sashalenz\Wiretables\Contracts\ButtonContract;
use Sashalenz\Wiretables\Modals\DeleteModal;
use Sashalenz\Wiretables\Modals\RestoreModal;

trait WithButtons
{
    use AuthorizesRequests;

    private array $actionButtons = [];
    public array $createButtonParams = [];
    public ?string $createButton = null;
    public ?string $showButton = null;
    public ?string $editButton = null;

    public function bootWithButtons(): void
    {
//
    }

    protected function can(string $ability, Model|string $model): bool
    {
        try {
            $this->authorize($ability, $model);

            return true;
        } catch (AuthorizationException) {
            return false;
        }
    }

    public function getAllowedButtonsProperty(): Collection
    {
        return $this->buttons()
            ->reject(fn (ButtonContract $button) => $button->isGlobal())
            ->when(
                $this->showButton,
                fn ($buttons) => $buttons->push(
                    LinkButton::make('show')
                        ->icon('heroicon-o-eye')
                        ->routeUsing(fn ($row) => route($this->showButton, $row))
                        ->displayIf(fn ($row) => $this->can('view', $row))
                )
            )
            ->when(
                $this->editButton,
                fn ($buttons) => $buttons->push(
                    ModalButton::make('edit')
                        ->icon('heroicon-o-pencil')
                        ->modal($this->editButton)
                        ->withParams(fn ($row) => [
                            'model' => $row->getKey(),
                        ])
                        ->displayIf(fn ($row) => $this->can('update', $row))
                )
            )
            ->push(
                ModalButton::make('delete')
                    ->icon('heroicon-o-trash')
                    ->modal(DeleteModal::getName())
                    ->withParams(fn ($row) => [
                        'modelName' => get_class($row),
                        'modelId' => $row->getKey(),
                    ])
                    ->displayIf(fn ($row) => $this->can('delete', $row))
            )
            ->when(
                method_exists($this->model, 'bootSoftDeletes'),
                fn ($buttons) => $buttons->push(
                    ModalButton::make('restore')
                        ->icon('heroicon-o-reply')
                        ->modal(RestoreModal::getName())
                        ->withParams(fn ($row) => [
                            'modelName' => get_class($row),
                            'modelId' => $row->getKey(),
                        ])
                        ->displayIf(fn ($row) => $this->can('restore', $row))
                )
            )
            ->filter(fn ($button) => $button instanceof ButtonContract);
    }

    public function getGlobalButtonsProperty(): Collection
    {
        return $this->buttons()
            ->filter(fn (ButtonContract $button) => $button->isGlobal())
            ->when(
                $this->createButton,
                fn ($buttons) => $buttons->push(
                    ModalButton::make('create')
                        ->icon('heroicon-o-plus')
                        ->title(__('wiretables::table.add'))
                        ->modal($this->createButton)
                        ->withParams(fn () => $this->createButtonParams)
                        ->displayIf(fn () => $this->can('create', $this->model))
                )
            )
            ->filter(fn ($button) => $button instanceof ButtonContract);
    }

    protected function getActionColumn(): ?ActionColumn
    {
        if (! $this->allowedButtons->count()) {
            return null;
        }

        return ActionColumn::make('action')
            ->withButtons($this->allowedButtons);
    }

    protected function buttons(): Collection
    {
        return collect();
    }
}
