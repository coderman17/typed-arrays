<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

class IntToIntArray extends IntToValueArray
{
    public function setItem(int $key, int $value): void
    {
        $this->items[$key] = $value;
    }

    public function pushItem(int $value): void
    {
        array_push($this->items, $value);
    }
}
