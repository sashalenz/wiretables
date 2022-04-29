<?php

namespace Sashalenz\Wiretables\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use RuntimeException;
use Sashalenz\Wiretables\Contracts\ButtonContract;

abstract class Button extends Component implements ButtonContract
{
    protected string $name;
    protected ?string $title = null;
    protected ?string $icon = null;
    protected Collection $class;
    protected ?Closure $routeCallback = null;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    public function __construct($name)
    {
        $this->name = $name;
        $this->class = collect();
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    protected function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function class(...$class): self
    {
        $this->class->push($class);
        return $this;
    }

    protected function getClass($row): ?string
    {
        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $row) : null;

        if (!is_string($class) && !is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $this->class->push($class);

        return $this->class
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;
        return $this;
    }

    public function routeUsing(callable $routeCallback): self
    {
        $this->routeCallback = $routeCallback;
        return $this;
    }

    protected function hasRouteCallback(): bool
    {
        return is_callable($this->routeCallback);
    }

    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;
        return $this;
    }

    protected function canDisplay($row): bool
    {
        return is_callable($this->displayCondition) ? call_user_func($this->displayCondition, $row) : true;
    }

    protected function getRoute($row):? string
    {
        return is_callable($this->routeCallback) ? call_user_func($this->routeCallback, $row) : null;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function renderIt($row):? View
    {
        if (!$this->canDisplay($row)) {
            return null;
        }

        if (!$this->getTitle() && !$this->getIcon()) {
            throw new RuntimeException('Title or Icon must be presented');
        }

        return $this->render()
            ->with([
                'row' => $row,
                'class' => $this->getClass($row),
                'route' => $this->getRoute($row),
                'icon' => $this->getIcon(),
                'title' => $this->getTitle()
            ]);
    }
}
