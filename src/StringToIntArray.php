<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\StringToAnyMethods;

class StringToIntArray extends KeyToValueArray
{
    use StringToAnyMethods;

    public function setItem(string $key, int $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }
}