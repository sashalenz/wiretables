<?php

namespace Sashalenz\Wiretables\Contracts;

interface ActionContract
{
    public function setModel(string $model): self;
}
