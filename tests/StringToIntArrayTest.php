<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\StringToIntArray;


final class StringToIntArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $stringToIntArray = new StringToIntArray();
        $stringToIntArray->setItem('a1', 0);
        $stringToIntArray->setItem('b1', 1);
        $stringToIntArray->setItem('c1', 2);

        $stringToIntArray->unsetItem('b1');

        $this::assertSame(
            [
                'a1' => 0,
                'c1' => 2
            ],
            $stringToIntArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'unsetItem', 'key', $this),
            'string'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToIntArray = new StringToIntArray();

        //This test checks an exception is thrown rather than letting PHP quietly convert string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_CAST_AS_INT as $stringKey){
            TestHelpers::expectExceptionOnSetItem($stringToIntArray, $stringKey, 0, $this);
        }

        $this::assertSame(
            $stringToIntArray->getItems(),
            []
        );

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $stringToIntArray->setItem($stringKey, 0);
        }

        foreach ($stringToIntArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'setItem', 'value', $this),
            'int'
        );
    }
}
