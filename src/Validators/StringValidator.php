<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

class StringValidator implements ValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate($value): void
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException('Expected type "string" but received type "' . gettype($value) . '"');
        }
    }
}