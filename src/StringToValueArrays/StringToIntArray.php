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
     * @throws \TypeError
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetSet($key, $value): void
    {
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to set a non-string key on a typed array with string keys');
        }

        if(!is_int($value)){
            throw new \TypeError('An attempt was made to set a non-integer value on a typed array with integer values');
        }

        $this->setItem($key, $value);
    }
}