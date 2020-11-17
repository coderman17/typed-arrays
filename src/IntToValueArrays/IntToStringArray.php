<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

class IntToStringArray extends IntToValueArray
{
    public function setItem(int $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(string $value): void
    {
        array_push($this->items, $value);
    }
}