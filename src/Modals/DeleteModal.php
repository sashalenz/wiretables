<?php

namespace Sashalenz\Wiretables\Modals;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Modal\ModalComponent;

class DeleteModal extends ModalComponent
{
    public Model $model;

    public function mount(string $model, int $id): void
    {
        $this->model = app($model)->findOrFail($id);
    }

    public function submit(): void
    {
        Gate::authorize('delete', $this->model);

        $this->model->delete();

        $this->dispatchBrowserEvent('$refresh');
        $this->closeModal();
    }

    public function render(): View
    {
        return view('wiretables::modals.delete-modal');
    }
}
