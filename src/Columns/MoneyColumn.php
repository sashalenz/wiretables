<?php

namespace Sashalenz\Wiretables\Columns;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
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
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('ru-RU', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        if ($this->showSign) {
            $value = $value->absolute();
        }

        $string = $formatter->format($value);

        if ($this->hideSymbol) {
            $array = Str::of($string)->explode(' ');
            $array->pop();

            return $array->implode(' ');
        }

        if ($value->getCurrency()->getCode() === 'UAH') {
            $string = str_replace('₴', 'грн', $string);
        }

        return $string;
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
                'amount' => $this->getAmount($row->{$this->getName()}),
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables::columns.money-column');
    }
}
