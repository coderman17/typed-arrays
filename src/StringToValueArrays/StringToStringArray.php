<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

class StringToStringArray extends StringToValueArray
{
    public function setItem(string $key, string $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }
}