<?php

namespace Sashalenz\Wiretables\Modals;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class RestoreModal extends ModalComponent
{
    use AuthorizesRequests;

    public string $modelName;
    public int $modelId;
    public Model $model;

    public function mount(string $modelName, int $modelId): void
    {
        $this->model = app($modelName)
            ->onlyTrashed()
            ->findOrFail($modelId);
    }

    /**
     * @throws AuthorizationException
     */
    public function submit(): void
    {
        $this->authorize('restore', $this->model);

        $this->model->restore();

        $this->closeModalWithEvents([
            '$refresh'
        ]);
    }

    public function render(): View
    {
        return view('wiretables::modals.restore-modal');
    }
}
