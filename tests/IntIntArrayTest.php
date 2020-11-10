<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\IntIntArray;


final class IntIntArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $intIntArray = new IntIntArray();
        $intIntArray->setItem(0, 0);
        $intIntArray->setItem(1, 1);
        $intIntArray->setItem(2, 2);

        $intIntArray->unsetItem(1);

        $this::assertSame(
            [
                0 => 0,
                2 => 2
            ],
            $intIntArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntIntArray', 'unsetItem', 'key', $this),
            'int'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $intIntArray = new IntIntArray();
        $intIntArray->setItem(0, 0);
        $this::assertSame(
            [0 => 0],
            $intIntArray->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntIntArray', 'setItem', 'key', $this),
            'int'
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntIntArray', 'setItem', 'value', $this),
            'int'
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $intIntArray = new IntIntArray();
        $intIntArray->pushItem(0);
        $this::assertSame(
            [
                0 => 0
            ],
            $intIntArray->getItems()
        );
    }

    public function testSetItemPushItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntIntArray', 'pushItem', 'value', $this),
            'int'
        );
    }
}
