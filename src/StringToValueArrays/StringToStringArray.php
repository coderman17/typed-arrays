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

        if(!is_string($value)){
            throw new \TypeError('An attempt was made to set a non-string value on a typed array with string values');
        }

        $this->setItem($key, $value);
    }
}