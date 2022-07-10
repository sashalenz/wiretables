<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class FileDownloadColumn extends Column
{
    public ?string $collection = null;

    public function collection(string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function renderIt($row): ?string
    {
        if ($this->hasDisplayCallback()) {
            return $this->display($row);
        }

        if (is_null($this->render())) {
            return $this->getValue($row);
        }

        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'data' => $row->getMedia($this->collection)
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.file-download-column');
    }
}
