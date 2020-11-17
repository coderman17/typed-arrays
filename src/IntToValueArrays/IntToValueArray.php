<?php

declare(strict_types = 1);

namespace TypedArrays\IntToValueArrays;

use TypedArrays\KeyToValueArray;

abstract class IntToValueArray extends KeyToValueArray
{
    public function unsetItem(int $key): void
    {
        unset($this->items[$key]);
    }
}
