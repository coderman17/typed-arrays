<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @throws \InvalidArgumentException
     */
    public function validate($value): void;
}