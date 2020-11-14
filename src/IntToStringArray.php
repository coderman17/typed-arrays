<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntToAnyMethods;

class IntToStringArray extends TypedKeyValueArray
{
    use IntToAnyMethods;

    public function setItem(int $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(string $value): void
    {
        array_push($this->items, $value);
    }
}