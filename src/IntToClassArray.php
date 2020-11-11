<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Traits\IntKeyAnyValue;

abstract class IntToClassArray extends TypedKeyValueArray
{
    use IntKeyAnyValue;

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

    protected function checkClass(object $value): void
    {
        if (get_class($value) !== $this->className) {
            throw new \Exception('Given object is of incorrect class');
        }
    }
}
