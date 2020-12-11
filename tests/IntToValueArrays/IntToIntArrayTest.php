<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToIntArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToIntArray';
    }

    //setItem:

    public function testSetItem(): void
    {
        $intToIntArray = new IntToIntArray();
        $intToIntArray->setItem(0, 0);
        $this::assertSame(
            [
                0 => 0
            ],
            $intToIntArray->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this)
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this)
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $intToIntArray = new IntToIntArray();
        $intToIntArray->pushItem(0);
        $this::assertSame(
            [
                0 => 0
            ],
            $intToIntArray->getItems()
        );
    }

    public function testPushItemValueIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'pushItem', 'value', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $intToIntArray = new IntToIntArray();

        $intToIntArray[0] = 0;

        $this::assertSame(
            [
                0 => 0
            ],
            $intToIntArray->getItems()
        );
    }

    public function testOffsetSetKeyError(): void
    {
        $intToIntArray = new IntToIntArray();

        $this::expectException('TypeError');

        $intToIntArray['0'] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $intToIntArray = new IntToIntArray();

        $this::expectException('TypeError');

        $intToIntArray[0] = '0';
    }
}
