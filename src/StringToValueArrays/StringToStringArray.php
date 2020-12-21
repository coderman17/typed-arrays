<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\NonCastedStringValidator;
use TypedArrays\Validators\IValidate;
use TypedArrays\Validators\StringValidator;

class StringToStringArray extends KeyToValueArray
{
    /**
     * @param string $key
     * @param string $value
     * @throws \Exception
     */
    public function setItem(string $key, string $value): void
    {
        $this->validateKey($key);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @throws \Exception
     */
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
        return new StringValidator();
    }
}