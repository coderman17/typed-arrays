<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\Traits\KeyToClassMethods;

abstract class StringToClassArray extends StringToValueArray
{
    use KeyToClassMethods;

    public function setItem(string $key, object $value): void
    {
        $this->checkClass($value);

        $this->checkForKeyCasting($key);

        $this->items[$key] = $value;
    }

    public function offsetSet($key, $value)
    {
        $this->setItem($key, $value);
    }
}
