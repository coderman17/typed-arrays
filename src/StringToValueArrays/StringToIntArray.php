<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

class StringToIntArray extends StringToValueArray
{
    /**
     * @param string $key
     * @param int $value
     * @throws \Exception
     */
    public function setItem(string $key, int $value): void
    {
        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @param int $value
     * @throws \Exception
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetSet($key, $value): void
    {
        $this->setItem($key, $value);
    }
}