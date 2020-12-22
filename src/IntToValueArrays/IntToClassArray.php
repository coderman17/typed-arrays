<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\ClassValidator;
use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\IValidate;

abstract class IntToClassArray extends KeyToValueArray
{
    /**
     * @param int $key
     * @param object $value
     * @throws \InvalidArgumentException
     */
    public function setItem(int $key, object $value): void
    {
        $this->validateValue($value);

        $this->items[$key] = $value;
    }

    /**
     * @param int $key
     */
    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @param object $value
     * @throws \InvalidArgumentException
     */
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
