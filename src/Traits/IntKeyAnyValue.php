<?php

declare(strict_types = 1);

namespace TypedArrays\Traits;

trait IntKeyAnyValue
{
    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }
}
