<?php /** @noinspection PhpUnused */

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
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetUnset($key): void
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to unset an array with integer keys, using a non-integer');
        }

        unset($this->items[$key]);
    }

    /**
     * @param int $key
     * @return bool
     * @throws \TypeError
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
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
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetGet($key)
    {
        if(!is_int($key)){
            throw new \TypeError('An attempt was made to get a value via a non-integer key, on an array with only integer keys');
        }

        return $this->items[$key];
    }
}
