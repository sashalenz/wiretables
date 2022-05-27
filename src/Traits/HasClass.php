<?php

namespace Sashalenz\Wiretables\Traits;

use Closure;
use Illuminate\Support\Collection;

trait HasClass
{
    protected array $class = [];
    protected ?Closure $styleCallback = null;

    public function class(string $class): self
    {
        $this->class[] = $class;

        return $this;
    }

    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;

        return $this;
    }

    public function toCenter(): self
    {
        $this->class[] = 'text-center';

        return $this;
    }

    public function noWrap(): self
    {
        $this->class[] = 'whitespace-nowrap';

        return $this;
    }

    public function font(string $font): self
    {
        $this->class[] = "font-$font";

        return $this;
    }

    public function bold(): self
    {
        return $this->font('bold');
    }

    public function text(string $text): self
    {
        $this->class[] = "text-$text";

        return $this;
    }

    public function small(): self
    {
        return $this->text('xs')->font('light');
    }

    public function getClass($row): ?string
    {
        return collect()
            ->push($this->class)
            ->when(
                is_callable($this->styleCallback),
                fn ($collection) => $collection->push(call_user_func($this->styleCallback, $row))
            )
            ->when(
                $this->hasHighlight && ! is_null($this->highlight),
                fn (Collection $collection) => $collection->when(
                    $this->hasDisplayCallback(),
                    fn (Collection $collection) => $collection->when(
                        $this->isHighlighting($this->display($row)),
                        fn (Collection $collection) => $collection->push('text-green-500')
                    ),
                    fn (Collection $collection) => $collection->when(
                        is_null($this->render()) && $this->isHighlighting($this->getValue($row)),
                        fn (Collection $collection) => $collection->push('text-green-500')
                    )
                )
            )
            ->filter()
            ->flatten()
            ->unique()
            ->implode(' ');
    }
}
