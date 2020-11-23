<?php /** @noinspection PhpUnused */

declare(strict_types = 1);

namespace TypedArrays;

abstract class KeyToValueArray implements \Iterator, \Countable, \ArrayAccess
{
    protected array $items = [];

    public function getItems(): array
    {
        return $this->items;
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

    public function count(): int
    {
        return count($this->items);
    }
}

