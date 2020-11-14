<?php

declare(strict_types = 1);

namespace TypedArrays\Traits;

trait StringToAnyMethods
{
    public function unsetItem(string $key): void
    {
        unset($this->items[$key]);
    }

    protected function validateKey(string $key): void
    {
        preg_match('/^[1-9][0-9]+|^[0-9]|^[-][1-9][0-9]*$/', $key, $matches);

        if (!isset($matches[0])) {
            return;
        }

        if ($matches[0] === $key) {
            throw new \Exception(
                "PHP will silently cast the key '" . $key . "' to an integer, violating the key type of string"
            );
        }
    }
}
