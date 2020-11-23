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

    /**
     * @param int $key
     * @param string $value
     * @throws \TypeError
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetSet($key, $value): void
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to set a non-integer key on a typed array with integer keys');
        }

        if(!is_string($value)){
            throw new \TypeError('An attempt was made to set a non-string value on a typed array with string values');
        }

        $this->setItem($key, $value);
    }
}