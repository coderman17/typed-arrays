<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

class StringToIntArray extends StringToValueArray
{
    public function setItem(string $key, int $value): void
    {
        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    public function offsetSet($key, $value)
    {
        $this->setItem($key, $value);
    }
}