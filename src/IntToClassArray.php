<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntToAnyMethods;
use TypedArrays\Traits\AnyToClassMethods;

abstract class IntToClassArray extends KeyToValueArray
{
    use IntToAnyMethods;
    use AnyToClassMethods;

    protected string $className = '';

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
}
