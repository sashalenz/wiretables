<?php

namespace Sashalenz\Wiretables\Columns;

use Money\Money;
use Illuminate\Contracts\View\View;
use NumberFormatter;

class MoneyColumn extends Column
{
    public string $currency;
    public bool $hideSymbol = false;
    public bool $showSign = false;
    protected array $class = ['font-bold'];

    public function hideSymbol(): self
    {
        $this->hideSymbol = true;

        return $this;
    }

    public function showSign(): self
    {
        $this->showSign = true;

        return $this;
    }

    public function getAmount(Money $value): string
    {
        if ($this->showSign && $value->isNegative()) {
            $value = $value->absolute();
        }


        $formatter = new NumberFormatter('ru_RU', NumberFormatter::CURRENCY);
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, 2);

        if ($this->hideSymbol) {
            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
            $formatter->setSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL, '');
        }

        return $formatter->formatCurrency(
            $value->getAmount() / 100,
            $value->getCurrency()->getCode()
        );
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
                'data' => $row->{$this->getName()},
                'showSign' => $this->showSign,
                'amount' => $this->getAmount($row->{$this->getName()})
            ])
            ->render();
    }

    public function render():? View
    {
        return view('wiretables::columns.money-column');
    }
}
