<?php

declare(strict_types = 1);

namespace TypedArrays\Traits;

trait AnyToClassMethods
{
    protected function checkClass(object $value): void
    {
        if (get_class($value) !== $this->className) {
            throw new \TypeError('Given object is of incorrect class');
        }
    }
}
