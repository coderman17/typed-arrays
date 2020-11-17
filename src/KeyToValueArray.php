<?php

declare(strict_types = 1);

namespace TypedArrays;

abstract class KeyToValueArray implements \Iterator
{
    protected array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int|string $key
     * @param mixed $value
     */
    public function setItems($key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    /**
     * @return int|string
     */
    public function key()
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return isset($this->items[$this->key()]);
    }

    public function rewind(): void
    {
        reset($this->items);
    }
}

