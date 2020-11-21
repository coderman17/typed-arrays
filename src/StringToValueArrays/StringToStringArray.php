<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

class StringToStringArray extends StringToValueArray
{
    public function setItem(string $key, string $value): void
    {
        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function offsetSet($key, $value)
    {
        $this->setItem($key, $value);
    }
}