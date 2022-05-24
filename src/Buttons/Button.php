<?php

namespace Sashalenz\Wiretables\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use JsonException;
use RuntimeException;
use Sashalenz\Wiretables\Contracts\ButtonContract;

abstract class Button extends Component implements ButtonContract
{
    protected string $name;
    protected ?string $title = null;
    protected ?string $icon = null;

    protected array $classes = [];
    protected bool $global = false;

    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;
    protected ?Closure $routeCallback = null;
    protected ?Closure $routeParams = null;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function global(): self
    {
        $this->global = true;

        return $this;
    }

    public function class(string $classes): self
    {
        $this->classes = array_merge(
            $this->classes,
            explode(' ', $classes)
        );

        return $this;
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

    public function withParams(callable $params): self
    {
        $this->routeParams = $params;

        return $this;
    }

    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    protected function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function getClass($row = null): ?string
    {
        return collect($this->classes)
            ->when(
                is_callable($this->styleCallback) && ! is_null($row),
                fn ($class) => $class->push((string) call_user_func($this->styleCallback, $row))
            )
            ->filter()
            ->flatten()
            ->unique()
            ->implode(' ');
    }

    protected function canDisplay($row = null): bool
    {
        return is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $row)
            : true;
    }

    private function hasRouteCallback(): bool
    {
        return is_callable($this->routeCallback);
    }

    protected function getRoute($row = null)
    {
        return $this->hasRouteCallback()
            ? call_user_func($this->routeCallback, $row)
            : null;
    }

    protected function getRouteParams($row = null)
    {
        return is_callable($this->routeParams)
            ? call_user_func($this->routeParams, $row)
            : null;
    }

    public function isGlobal(): bool
    {
        return $this->global;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    /**
     * @throws JsonException
     */
    public function renderIt($row = null): ?View
    {
        if (! $this->canDisplay($row)) {
            return null;
        }

        if (! $this->getTitle() && ! $this->getIcon()) {
            throw new RuntimeException('Title or Icon must be presented');
        }

        return $this->render()
            ->with([
                'icon' => $this->getIcon(),
                'title' => $this->getTitle(),
                'class' => $this->getClass($row),
                'route' => $this->getRoute($row),
                'params' => $this->getRouteParams($row),
                'row' => $row,
            ]);
    }
}
