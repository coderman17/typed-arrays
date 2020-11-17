<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\KeyToValueArray;

final class KeyToValueArrayTest extends TestCase
{
    //setItem, getItem:

    public function testSetItem(): void
    {
        $keyToValueArray = new class extends KeyToValueArray{};
        $keyToValueArray->setItems(0, 0);
        $this::assertSame(
            [0 => 0],
            $keyToValueArray->getItems()
        );
    }

    //iterator:

    public function testIterator(): void
    {
        $keyToValueArray = new class extends KeyToValueArray{};
        $keyToValueArray->setItems(0, 0);
        $keyToValueArray->setItems("string1", "string2");
        $keyToValueArray->setItems(2, true);
        $string = null;
        $array = [];
        foreach ($keyToValueArray as $k => $v){
            $array[$k] = $v;
        }
        $this::assertSame(
            $array,
            $keyToValueArray->getItems()
        );
    }

    //countable:

    public function testCountable(): void
    {
        $keyToValueArray = new class extends KeyToValueArray{};
        $keyToValueArray->setItems(0, 0);
        $keyToValueArray->setItems(1, 1);
        $keyToValueArray->setItems(2, 2);
        $this::assertSame(
            count($keyToValueArray),
            3
        );
    }
}