<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\ValidatorInterface;
use TypedArrays\Validators\StringValidator;

class IntToStringArray extends AbstractTypedArray
{
    public function setItem(int $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }

    public function pushItem(string $value): void
    {
        array_push($this->items, $value);
    }

    protected function getKeyValidator(): ValidatorInterface
    {
        return new IntValidator();
    }

    protected function getValueValidator(): ValidatorInterface
    {
        return new StringValidator();
    }
}