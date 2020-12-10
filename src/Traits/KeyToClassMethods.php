<?php

declare(strict_types = 1);

namespace TypedArrays\Traits;

trait KeyToClassMethods
{
    protected string $className = '';

    /**
     * @param object $value
     * @throws \TypeError
     */
    protected function checkClass(object $value): void
    {
        if (get_class($value) !== $this->className) {
            throw new \TypeError('Expected an object of class "' . $this->className . '", but received one of class "' . get_class($value) . '"');
        }
    }
}
