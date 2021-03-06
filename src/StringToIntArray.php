<?php

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\ValidatorInterface;
use TypedArrays\Validators\NonCastedStringValidator;

class StringToIntArray extends AbstractTypedArray
{
    /**
     * @param string $key
     * @param int $value
     * @throws \InvalidArgumentException
     */
    public function setItem(string $key, int $value): void
    {
        $this->validateKey($key);

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
        return new IntValidator();
    }
}