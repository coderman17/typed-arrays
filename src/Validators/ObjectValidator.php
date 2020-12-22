<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ObjectValidator implements IValidate
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_object($value)) {
            throw new \InvalidArgumentException('Expected an object type but received a ' . gettype($value));
        }
    }
}