<?php

namespace Sashalenz\Wiretables\Actions;

use Closure;
use Illuminate\Support\Collection;
use Sashalenz\Wiretables\Contracts\ActionContract;

abstract class Action implements ActionContract
{
    private string $model;
    private int $size = 6;
    private ?string $title = null;
    private ?string $icon = null;
    private ?Collection $class = null;
    private ?Closure $displayCondition = null;

    public function __construct(private readonly string $name) { }

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

    public function getIcon():? string
    {
        return $this->icon;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function class(...$class): self
    {
        $this->class->push($class);

        return $this;
    }

    public function getClass():? string
    {
        return $this->class
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    public function size(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;

        return $this;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }
}
