<?php

namespace Sashalenz\Wiretables\Columns;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Sashalenz\Wireforms\Traits\Authorizable;
use Sashalenz\Wiretables\Contracts\ColumnContract;

abstract class Column extends Component implements ColumnContract
{
    use Authorizable;

    private string $name;
    private array $class = [];
    private ?string $title = null;
    private bool $sortable = false;
    private ?string $sortableField = null;
    private ?int $width = null;
    private ?Closure $styleCallback = null;
    private ?Closure $displayCallback = null;
    private ?Closure $displayCondition = null;

    protected ?string $currentSort = null;
    protected ?string $highlight = null;
    public bool $hasHighlight = false;
    public bool $canRender = true;

    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract public function render(): ?View;

    public function title(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function sortable(?string $field = null): self
    {
        $this->sortable = true;
        $this->sortableField = $field;

        return $this;
    }

    public function class(string $class): self
    {
        $this->class[] = $class;

        return $this;
    }

    public function width(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function highlight(string $highlight): self
    {
        $this->highlight = $highlight;

        return $this;
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

    public function currentSort($sort): self
    {
        $this->currentSort = $sort;

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

    public function canSee(string $ability, string $model): self
    {
        $this->canRender = $this->authorizeModel($ability, $model);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function getSortableField(): string
    {
        return $this->sortableField ?? $this->name;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    private function isHighlighting(string $value): bool
    {
        return Str::of($value)
            ->lower()
            ->contains(
                Str::of($this->highlight)->lower()
            );
    }

    public function canDisplay($row): bool
    {
        return is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $row)
            : true;
    }

    public function hasDisplayCallback(): bool
    {
        return is_callable($this->displayCallback);
    }

    public function display($row): string
    {
        return call_user_func($this->displayCallback, $row);
    }

    public function getSlotName(): string
    {
        return sprintf('column_%s', $this->getName());
    }

    protected function getValue($row): ?string
    {
        return data_get($row->toArray(), $this->getName());
    }

    public function renderTitle(): ?string
    {
        if (is_null($this->currentSort) || !$this->isSortable()) {
            return $this->getTitle();
        }

        return view('wiretables::partials.table-title')
            ->with([
                'name' => $this->getSortableField(),
                'title' => $this->getTitle(),
                'isCurrentSort' => Str::of($this->currentSort)
                    ->replaceFirst('-', '')
                    ->is($this->getSortableField()),
                'isSortUp' => $this->currentSort === $this->getSortableField(),
                'sort' => $this->currentSort,
            ])
            ->render();
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
                'row' => $row,
            ])
            ->render();
    }

    public static function make(string $name): static
    {
        return new static($name);
    }
}
