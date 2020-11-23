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
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetSet($key, $value): void
    {
        $this->setItem($key, $value);
    }
}
