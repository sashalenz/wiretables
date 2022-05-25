<?php

namespace Sashalenz\Wiretables;

use Illuminate\Contracts\View\View;
use Sashalenz\Wiretables\Buttons\ModalButton;
use Sashalenz\Wiretables\Contracts\ButtonContract;
use Sashalenz\Wiretables\Traits\WithActions;
use Sashalenz\Wiretables\Traits\WithButtons;

abstract class Card extends Wiretable
{
    use WithButtons;
    use WithActions;

    public bool $withHeader = false;
    public bool $withFooter = false;

    protected function getCreateButton(): ButtonContract
    {
        return ModalButton::make('create')
            ->icon('heroicon-o-plus-circle')
            ->modal($this->createButton)
            ->class('px-4 h-full !rounded-none')
            ->withParams(fn () => $this->getCreateButtonParams())
            ->displayIf(fn () => $this->can('create', $this->model));
    }

    public function render(): View
    {
        return view('wiretables::card');
    }
}
