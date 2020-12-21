<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\ClassValidator;
use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\IValidate;

abstract class IntToClassArray extends KeyToValueArray
{
    public function setItem(int $key, object $value): void
    {
        $this->validateKey($key);

        $this->validateValue($value);

        $this->items[$key] = $value;
    }

    public function unsetItem(int $key): void
    {
        $this->validateKey($key);

        unset($this->items[$key]);
    }

    public function pushItem(object $value): void
    {
        $this->validateValue($value);

        array_push($this->items, $value);
    }

    protected function getKeyValidator(): IValidate
    {
        return new IntValidator();
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
