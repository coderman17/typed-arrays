<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\StringToAnyMethods;

class StringToStringArray extends KeyToValueArray
{
    use StringToAnyMethods;

    public function setItem(string $key, string $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }
}