<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\StringKeyAnyValue;

class StringToIntArray extends TypedKeyValueArray
{
    use StringKeyAnyValue;

    public function setItem(string $key, int $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }
}