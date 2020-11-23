<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\Traits\KeyToClassMethods;

abstract class StringToClassArray extends StringToValueArray
{
    use KeyToClassMethods;

    /**
     * @param string $key
     * @param object $value
     * @throws \Exception
     */
    public function setItem(string $key, object $value): void
    {
        $this->checkClass($value);

        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @param object $value
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

        if(!is_object($value)){
            throw new \TypeError('An attempt was made to set a non-object value on a typed array with object values');
        }

        $this->setItem($key, $value);
    }
}
