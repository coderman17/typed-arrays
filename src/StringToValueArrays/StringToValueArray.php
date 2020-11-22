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
     * @param string $key
     * @throws \TypeError
     */
    public function offsetUnset($key)
    {
        //this has to be checked explicitly to avoid PHP type casting
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to unset an array with string keys, using a non-string');
        }

        $this->unsetItem($key);
    }

    /**
     * @param string $key
     * @throws \TypeError
     * @return bool
     */
    public function offsetExists($key): bool
    {
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to check whether a non-string key exists on an array with string keys');
        }

        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @throws \TypeError
     * @return mixed
     */
    public function offsetGet($key)
    {
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to get a value via a non-string key, on an array with only string keys');
        }

        return $this->items[$key];
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
