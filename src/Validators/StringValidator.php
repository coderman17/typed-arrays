<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class StringValidator implements IValidate
{
    /**
     * @param mixed $value
     * @throws \TypeError
     */
    public function validate($value): void
    {
        if (!is_string($value)) {
            throw new \TypeError('Expected a string type but received a ' . gettype($value));
        }
    }
}