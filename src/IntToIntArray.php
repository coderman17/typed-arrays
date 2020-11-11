<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntKeyAnyValue;

class IntToIntArray extends TypedKeyValueArray
{
    use IntKeyAnyValue;

    public function setItem(int $key, int $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(int $value): void
    {
        array_push($this->items, $value);
    }
}
