<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Validators\ClassValidator;
use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\ValidatorInterface;

abstract class IntToClassArray extends AbstractTypedArray
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

    protected function getKeyValidator(): ValidatorInterface
    {
        return new IntValidator();
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
