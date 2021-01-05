<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Validators\ClassValidator;
use TypedArrays\Validators\ValidatorInterface;
use TypedArrays\Validators\NonCastedStringValidator;

abstract class StringToClassArray extends AbstractTypedArray
{
    /**
     * @param string $key
     * @param object $value
     * @throws \InvalidArgumentException
     */
    public function setItem(string $key, object $value): void
    {
        $this->validateKey($key);

        $this->validateValue($value);

        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @throws \InvalidArgumentException
     */
    public function unsetItem(string $key): void
    {
        $this->validateKey($key);

        unset($this->items[$key]);
    }

    protected function getKeyValidator(): ValidatorInterface
    {
        return new NonCastedStringValidator();
    }

    protected function getValueValidator(): ValidatorInterface
    {
        return new ClassValidator($this->getClassName());
    }

    /**
     * @return class-string
     */
    abstract protected function getClassName(): string;
}
