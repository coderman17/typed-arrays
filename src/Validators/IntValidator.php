<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class IntValidator implements IValidate
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException('Expected an integer type but received a ' . gettype($value));
        }
    }
}