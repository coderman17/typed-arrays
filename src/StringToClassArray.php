<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\StringToAnyMethods;
use TypedArrays\Traits\AnyToClassMethods;

abstract class StringToClassArray extends KeyToValueArray
{
    use StringToAnyMethods;
    use AnyToClassMethods;

    protected string $className = '';

    public function setItem(string $key, object $value): void
    {
        $this->checkClass($value);

        $this->validateKey($key);

        $this->items[$key] = $value;
    }
}
