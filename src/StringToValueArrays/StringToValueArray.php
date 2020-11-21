<?php

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\KeyToValueArray;

abstract class StringToValueArray extends KeyToValueArray
{
    public function unsetItem(string $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        //this has to be checked explicitly to avoid PHP type casting
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to unset an array with string keys, using a non-string');
        }

        $this->unsetItem($key);
    }

    protected function checkForKeyCasting(string $key): void
    {
        preg_match('/^[1-9][0-9]+|^[0-9]|^[-][1-9][0-9]*$/', $key, $matches);

        if (!isset($matches[0])) {
            return;
        }

        if ($matches[0] === $key) {
            throw new \Exception(
                "PHP was about to silently cast the key '" . $key . "' to an integer, an exception was thrown instead"
            );
        }
    }
}
