<?php

namespace Sashalenz\Wiretables;

use Illuminate\Contracts\View\View;
use Sashalenz\Wiretables\Traits\WithActions;
use Sashalenz\Wiretables\Traits\WithButtons;
use Sashalenz\Wiretables\Traits\WithFiltering;
use Sashalenz\Wiretables\Traits\WithPagination;
use Sashalenz\Wiretables\Traits\WithSearching;
use Sashalenz\Wiretables\Traits\WithSorting;

abstract class Table extends Wiretable
{
    use WithFiltering;
    use WithSorting;
    use WithSearching;
    use WithButtons;
    use WithActions;

    public ?string $layout = null;

    public function render(): View
    {
        return view('wiretables::table')
            ->extends(
                $this->layout ?? config('wiretables.layout'),
                ['title' => $this->getTitleProperty()]
            );
    }
}
