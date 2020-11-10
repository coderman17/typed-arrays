<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntKeyAnyValue;

class IntStringArray extends TypedKeyValueArray
{
    use IntKeyAnyValue;

    public function setItem(int $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(string $value): void
    {
        array_push($this->items, $value);
    }
}