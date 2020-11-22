<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\KeyToValueArray;

abstract class IntToValueArray extends KeyToValueArray
{
    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @param int $key
     * @throws \TypeError
     */
    public function offsetUnset($key)
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to unset an array with integer keys, using a non-integer');
        }

        $this->unsetItem($key);
    }

    /**
     * @param int $key
     * @throws \TypeError
     * @return bool
     */
    public function offsetExists($key): bool
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to check whether a non-integer key exists on an array with integer keys');
        }

        return isset($this->items[$key]);
    }

    /**
     * @param int $key
     * @throws \TypeError
     * @return mixed
     */
    public function offsetGet($key)
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to get a value via a non-integer key, on an array with only integer keys');
        }

        return $this->items[$key];
    }
}
