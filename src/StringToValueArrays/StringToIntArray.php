<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\IValidate;
use TypedArrays\Validators\NonCastedStringValidator;

class StringToIntArray extends KeyToValueArray
{
    public function setItem(string $key, int $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }

    public function unsetItem(string $key): void
    {
        $this->validateKey($key);

        unset($this->items[$key]);
    }

    protected function getKeyValidator(): IValidate
    {
        return new NonCastedStringValidator();
    }

    protected function getValueValidator(): IValidate
    {
        return new IntValidator();
    }
}