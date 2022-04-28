<?php

namespace Sashalenz\Wiretables\Columns;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class DateTime extends Column
{
    public string $format = 'Y-m-d H:i';

    public function __construct($name)
    {
        parent::__construct($name);

        $this->class('whitespace-nowrap text-gray-500');
    }

    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function renderIt($row):? string
    {
        $date = $row->{$this->getName()};

        if (!$date instanceof Carbon) {
            return $date;
        }

        return $date->format($this->format);
    }

    public function render():? View
    {
        return null;
    }
}
