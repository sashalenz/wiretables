<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class ImageColumn extends Column
{
    public function render(): View
    {
        return view('wiretables::columns.image-column');
    }
}
