<?php

declare(strict_types = 1);

namespace TypedArrays;

class StringToStringArray extends TypedKeyValueArray
{
    public function setItem(string $key, string $value): void
    {
        $this->items[$key] = $value;
    }
}