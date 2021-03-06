<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class ObjectValidator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_object($value)) {
            throw new \InvalidArgumentException('Expected type "object" but received type "' . gettype($value) . '"');
        }
    }
}