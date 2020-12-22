<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\KeyToValueArray;
use TypedArrays\Validators\IntValidator;
use TypedArrays\Validators\IValidate;
use TypedArrays\Validators\StringValidator;

class IntToStringArray extends KeyToValueArray
{
    public function setItem(int $key, string $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @param array<int, string> $array
     * @throws \TypeError
     * @throws \Exception this will actually only throw a TypeError, not Exception...
     */
    public function bulkSetItems(array $array): void
    {
        foreach ($array as $key => $value){
            $this->validateKey($key);

            $this->validateValue($value);

            $this->setItem($key, $value);
        }
    }

    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }

    public function pushItem(string $value): void
    {
        array_push($this->items, $value);
    }

    protected function getKeyValidator(): IValidate
    {
        return new IntValidator();
    }

    protected function getValueValidator(): IValidate
    {
        return new StringValidator();
    }
}