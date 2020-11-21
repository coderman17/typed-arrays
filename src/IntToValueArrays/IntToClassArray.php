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

    public function offsetSet($key, $value)
    {
        $this->setItem($key, $value);
    }
}
