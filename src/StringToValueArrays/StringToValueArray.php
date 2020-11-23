<?php /** @noinspection PhpUnused */

declare(strict_types = 1);

namespace TypedArrays\StringToValueArrays;

use TypedArrays\KeyToValueArray;

abstract class StringToValueArray extends KeyToValueArray
{
    /**
     * @param string $key
     * @throws \TypeError
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetUnset($key)
    {
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to unset an array with string keys, using a non-string');
        }

        unset($this->items[$key]);
    }

    /**
     * @param string $key
     * @return bool
     * @throws \TypeError
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
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
     *
     * Implements ArrayAccess so cannot add param type:
     * @noinspection PhpMissingParamTypeInspection
     */
    public function offsetGet($key)
    {
        if(!is_string($key)){
            throw new \TypeError('An attempt was made to get a value via a non-string key, on an array with only string keys');
        }

        return $this->items[$key];
    }

    /**
     * @param string $key
     * @throws \Exception
     */
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
