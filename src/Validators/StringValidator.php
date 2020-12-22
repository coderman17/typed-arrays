<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class StringValidator implements IValidate
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException('Expected a string type but received a ' . gettype($value));
        }
    }
}