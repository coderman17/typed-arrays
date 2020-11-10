<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\TypedKeyValueArray;

final class TypedKeyValueArrayTest extends TestCase
{
    //setItem, getItem:

    public function testSetItem(): void
    {
        $typedKeyValueArray = new class extends TypedKeyValueArray{};
        $typedKeyValueArray->setItems(0, 0);
        $this::assertSame(
            [0 => 0],
            $typedKeyValueArray->getItems()
        );
    }

    //iterator:

    public function testIterator(): void
    {
        $typedKeyValueArray = new class extends TypedKeyValueArray{};
        $typedKeyValueArray->setItems(0, 0);
        $typedKeyValueArray->setItems("string1", "string2");
        $typedKeyValueArray->setItems(2, true);
        $string = null;
        $array = [];
        foreach ($typedKeyValueArray as $k => $v){
            $array[$k] = $v;
        }
        $this::assertSame(
            $array,
            $typedKeyValueArray->getItems()
        );
    }
}