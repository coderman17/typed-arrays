<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToStringArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected IntToStringArray $array;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToStringArray';

        $this->array = new IntToStringArray();
    }

    //setItem:

    public function testSetItem(): void
    {
        $this->array->setItem(0, '0');
        $this->array->setItem(1, '1.0');
        $this->array->setItem(2, 'two');
        $this->array->setItem(3, 'false');
        $this->array->setItem(4, 'null');
        $this::assertSame(
            [
                0 => '0',
                1 => '1.0',
                2 => 'two',
                3 => 'false',
                4 => 'null'
            ],
            $this->array->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this)
        );
    }

    public function testSetItemValueIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this)
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $this->array->pushItem('0');

        $this::assertSame(
            [
                0 => '0'
            ],
            $this->array->getItems()
        );
    }

    public function testPushItemValueIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'pushItem', 'value', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $this->array[0] = '0';

        $this::assertSame(
            [
                0 => '0'
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException('TypeError');

        $this->array['0'] = 'a';
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException('TypeError');

        $this->array[0] = 0;
    }
}
