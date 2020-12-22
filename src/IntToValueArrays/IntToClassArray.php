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
     * @throws \Exception
     */
    public function setItem(int $key, object $value): void
    {
        $this->validateValue($value);

        $this->items[$key] = $value;
    }

    /**
     * @param array<int, object> $array
     * @throws \TypeError
     * @throws \Exception
     */
    public function bulkSetItems(array $array): void
    {
        foreach ($array as $key => $value){
            $this->validateKey($key);

            $this->validateValue($value);

            $this->setItem($key, $value);
        }
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
     * @throws \Exception
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
