<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;

class Money extends Column
{
    public string $currency;

    public function currency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrencySymbol():? string
    {
        $symbols = [
            'UAH' => 'far fa-hryvnia',
            'EUR' => 'far fa-euro-sign',
            'USD' => 'far fa-dollar-sign'
        ];

        return $symbols[$this->currency] ?? null;
    }

    public function renderIt($row):? string
    {
        return $this->getValue($row) . ' <i class="'. $this->getCurrencySymbol() .'"></i>';
    }

    public function render():? View
    {
        return null;
    }
}
