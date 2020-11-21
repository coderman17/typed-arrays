<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\KeyToValueArray;

final class KeyToValueArrayTest extends TestCase
{
    protected KeyToValueArray $keyToValueArray;

    public function setUp(): void
    {
        parent::setUp();

        $this->keyToValueArray = new class extends KeyToValueArray{
            public function setItem($key, $value){
                $this->items[$key] = $value;
            }
        };
    }
    
    //setItem, getItem:

    public function testSetItem(): void
    {
        $this->keyToValueArray->setItem(0, 0);
        $this::assertSame(
            [0 => 0],
            $this->keyToValueArray->getItems()
        );
    }

    //iterator:

    public function testIterator(): void
    {
        $this->keyToValueArray->setItem(0, 0);
        $this->keyToValueArray->setItem("string1", "string2");
        $this->keyToValueArray->setItem(2, true);
        $string = null;
        $array = [];
        foreach ($this->keyToValueArray as $k => $v){
            $array[$k] = $v;
        }
        $this::assertSame(
            $array,
            $this->keyToValueArray->getItems()
        );
    }

    //countable:

    public function testCountable(): void
    {
        $this->keyToValueArray->setItem(0, 0);
        $this->keyToValueArray->setItem(1, 1);
        $this->keyToValueArray->setItem(2, 2);
        $this::assertSame(
            count($this->keyToValueArray),
            3
        );
    }
}