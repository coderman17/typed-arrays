<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class IntValidator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException('Expected type "integer" but received type "' . gettype($value) . '"');
        }
    }
}