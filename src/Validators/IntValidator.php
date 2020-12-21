<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class IntValidator implements IValidate
{
    /**
     * @param mixed $value
     * @throws \TypeError
     */
    public function validate($value): void
    {
        if (!is_int($value)) {
            throw new \TypeError('Expected an integer type but received a ' . gettype($value));
        }
    }
}