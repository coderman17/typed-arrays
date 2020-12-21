<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\ClassValidator;
use TypedArrays\Validators\IValidate;
use TypedArrays\Validators\NonCastedStringValidator;

abstract class StringToClassArray extends KeyToValueArray
{
    /**
     * @param string $key
     * @param object $value
     * @throws \Exception
     */
    public function setItem(string $key, object $value): void
    {
        $this->validateKey($key);

        $this->validateValue($value);

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
        return new ClassValidator($this->getClassName());
    }

    /**
     * @return class-string
     */
    abstract protected function getClassName(): string;
}
