<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

class StringToStringArray extends StringToValueArray
{
    /**
     * @param string $key
     * @param string $value
     * @throws \Exception
     */
    public function setItem(string $key, string $value): void
    {
        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $value
     * @throws \Exception
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetSet($key, $value)
    {
        $this->setItem($key, $value);
    }
}