<?php

declare(strict_types = 1);

namespace TypedArrays\Traits;

trait IntToAnyMethods
{
    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }
}
