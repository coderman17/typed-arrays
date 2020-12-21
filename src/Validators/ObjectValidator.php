<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ObjectValidator implements IValidate
{
    /**
     * @param mixed $value
     * @throws \TypeError
     */
    public function validate($value): void
    {
        if (!is_object($value)) {
            throw new \TypeError('Expected an object type but received a ' . gettype($value));
        }
    }
}