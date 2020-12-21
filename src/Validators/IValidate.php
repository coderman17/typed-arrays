<?php

declare(strict_types = 1);

namespace TypedArrays\Validators;

interface IValidate
{
    /**
     * @param mixed $value
     * @throws \Exception
     * @throws \TypeError
     */
    public function validate($value): void;
}