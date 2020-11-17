<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntToAnyMethods;

class IntToIntArray extends KeyToValueArray
{
    use IntToAnyMethods;

    public function setItem(int $key, int $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(int $value): void
    {
        array_push($this->items, $value);
    }
}
