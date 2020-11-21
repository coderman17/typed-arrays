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
        //this has to be checked explicitly to avoid PHP type casting
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to unset an array with integer keys, using a non-integer');
        }

        $this->unsetItem($key);
    }
}
