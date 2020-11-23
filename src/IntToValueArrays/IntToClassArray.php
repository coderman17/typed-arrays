<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\Traits\KeyToClassMethods;

abstract class IntToClassArray extends IntToValueArray
{
    use KeyToClassMethods;

    public function setItem(int $key, object $value): void
    {
        $this->checkClass($value);

        $this->items[$key] = $value;
    }

    public function pushItem(object $value): void
    {
        $this->checkClass($value);

        array_push($this->items, $value);
    }

    /**
     * @param int $key
     * @param object $value
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

        if(!is_object($value)){
            throw new \TypeError('An attempt was made to set a non-object value on a typed array with object values');
        }

        $this->setItem($key, $value);
    }
}
