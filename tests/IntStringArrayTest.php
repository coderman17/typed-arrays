<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\IntStringArray;


final class IntStringArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $intStringArray = new IntStringArray();
        $intStringArray->setItem(0, '0');
        $intStringArray->setItem(1, '1');
        $intStringArray->setItem(2, '2');

        $intStringArray->unsetItem(1);

        $this::assertSame(
            [
                0 => '0',
                2 => '2'
            ],
            $intStringArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntStringArray', 'unsetItem', 'key'),
            'int'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $intStringArray = new IntStringArray();
        $intStringArray->setItem(0, '0');
        $intStringArray->setItem(1, '1.0');
        $intStringArray->setItem(2, 'two');
        $intStringArray->setItem(3, 'false');
        $intStringArray->setItem(4, 'null');
        $this::assertSame(
            [
                0 => '0',
                1 => '1.0',
                2 => 'two',
                3 => 'false',
                4 => 'null'
            ],
            $intStringArray->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntStringArray', 'setItem', 'key'),
            'int'
        );
    }

    public function testSetItemValueIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntStringArray', 'setItem', 'value'),
            'string'
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $intStringArray = new IntStringArray();
        $intStringArray->pushItem('0');
        $this::assertSame(
            [
                0 => '0'
            ],
            $intStringArray->getItems()
        );
    }

    public function testSetItemPushItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntStringArray', 'pushItem', 'value'),
            'string'
        );
    }
}
