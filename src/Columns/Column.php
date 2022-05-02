<?php

namespace Sashalenz\Wiretables\Columns;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use RuntimeException;
use Sashalenz\Wiretables\Contracts\ColumnContract;

abstract class Column extends Component implements ColumnContract
{
    private string $name;
    private Collection $class;
    private ?string $title = null;
    private bool $sortable = false;
    private ?int $width = null;
    private ?string $highlight = null;
    private ?Closure $styleCallback = null;
    private ?Closure $displayCallback = null;
    private ?Closure $displayCondition = null;
    private ?string $currentSort = null;

    protected bool $hasHighlight = false;

    public function __construct($name)
    {
        $this->name = $name;
        $this->class = collect();
    }

    abstract public function render(): ?View;

    public function title(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function class(...$class): self
    {
        $this->class->push($class);

        return $this;
    }

    public function getClass($row): ?string
    {
        $classes = collect();

        $classes->push($this->class);

        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $row) : null;

        if (! is_string($class) && ! is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $classes->push($class);

        if ($this->hasHighlight && ! is_null($this->getHighlight()) && ($this->getHighlight() === $this->getValue($row))) {
            $classes->push('text-green-700 font-semibold');
        }

        return $classes
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function width(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setHighlight(string $highlight): self
    {
        $this->highlight = $highlight;

        return $this;
    }

    private function getHighlight(): ?string
    {
        return $this->highlight;
    }

    public function displayUsing(callable $displayCallback): self
    {
        $this->displayCallback = $displayCallback;

        return $this;
    }

    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;

        return $this;
    }

    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;

        return $this;
    }

    public function toCenter(): self
    {
        $this->class->push('text-center');

        return $this;
    }

    public function setCurrentSort($sort): self
    {
        $this->currentSort = $sort;

        return $this;
    }

    public function getSlotName(): string
    {
        return sprintf('column_%s', $this->getName());
    }

    protected function getValue($row): ?string
    {
        return data_get($row->toArray(), $this->getName());
    }

    public function renderTitle():? string
    {
        if (is_null($this->currentSort) && ! $this->isSortable()) {
            return $this->getTitle();
        }

        return view('wiretables::partials.table-title')
            ->with([
                'name' => $this->getName(),
                'title' => $this->getTitle(),
                'isCurrentSort' => Str::of($this->currentSort)
                    ->replaceFirst('-', '')
                    ->is($this->getName()),
                'isSortUp' => $this->currentSort === $this->getName(),
                'sort' => $this->currentSort,
            ])
            ->render();
    }

    public function renderIt($row):? string
    {
        $condition = is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $row)
            : true;

        if ((bool) $condition === false) {
            return null;
        }

        if (is_null($this->render())) {
            return $this->getValue($row);
        }

        if (is_callable($this->displayCallback)) {
            return call_user_func($this->displayCallback, $row);
        }

        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'data' => $row->{$this->getName()},
                'row' => $row,
            ])
            ->render();
    }

    public static function make(string $name): static
    {
        return new static($name);
    }
}
