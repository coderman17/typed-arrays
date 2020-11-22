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
            /**
             * @param $key
             * @param $value
             */
            public function setItem($key, $value){
                $this->items[$key] = $value;
            }

            /**
             * @param $key
             * @param $value
             */
            public function offsetSet($key, $value){}

            /**
             * @param $key
             */
            public function offsetUnset($key){}

            /**
             * @param $offset
             */
            public function offsetGet($offset){}

            /**
             * @param $offset
             */
            public function offsetExists($offset){}
        };
    }

    //getItem:

    public function testGetItems(): void
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

    //2 of the arrayAccess methods implemented on this class:

//    public function testOffsetGet(): void
//    {
//        $this->keyToValueArray->setItem(0, 0);
//
//        $this::assertSame(
//            $this->keyToValueArray[0],
//            0
//        );
//    }
//
//    public function testOffsetExists(): void
//    {
//        $this->keyToValueArray->setItem(0, 0);
//        $this::assertSame(
//            isset($this->keyToValueArray[0]),
//            true
//        );
//
//        $this::assertSame(
//            isset($this->keyToValueArray[1]),
//            false
//        );
//    }
}