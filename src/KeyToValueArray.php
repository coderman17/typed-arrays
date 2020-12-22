<?php /** @noinspection PhpUnused */

declare(strict_types = 1);

namespace TypedArrays;

use TypedArrays\Validators\IValidate;

abstract class KeyToValueArray implements \Iterator, \Countable, \ArrayAccess
{
    protected array $items = [];

    protected IValidate $keyValidator;

    protected IValidate $valueValidator;

    public function __construct()
    {
        $this->keyValidator = $this->getKeyValidator();

        $this->valueValidator = $this->getValueValidator();
    }

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
     * @return int|string|null
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

    /**
     * @param int|string $offset
     * @throws \InvalidArgumentException
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->validateKey($offset);

        $this->validateValue($value);

        $this->items[$offset] = $value;
    }

    /**
     * @param int|string $offset
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $this->validateKey($offset);

        return $this->items[$offset];
    }

    /**
     * @param int|string $offset
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        $this->validateKey($offset);

        return isset($this->items[$offset]);
    }

    /**
     * @param int|string $offset
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset): void
    {
        $this->validateKey($offset);

        unset($this->items[$offset]);
    }

    /**
     * @param mixed $key
     * @throws \InvalidArgumentException
     */
    protected function validateKey($key): void
    {
        $this->keyValidator->validate($key);
    }

    /**
     * @param mixed $value
     * @throws \InvalidArgumentException
     */
    protected function validateValue($value): void
    {
        $this->valueValidator->validate($value);
    }

    abstract protected function getKeyValidator(): IValidate;

    abstract protected function getValueValidator(): IValidate;
}

