<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToIntArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected IntToIntArray $array;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToIntArray';

        $this->array = new IntToIntArray();
    }

    //setItem:

    public function testSetItem(): void
    {
        $this->array->setItem(0, 0);

        $this::assertSame(
            [
                0 => 0
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

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this)
        );
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->array->setItem(0, 0);

        $this->array->setItem(1, 1);

        $this->array->unsetItem(0);

        $this::assertSame(
            [
                1 => 1
            ],
            $this->array->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $this->array->pushItem(0);

        $this::assertSame(
            [
                0 => 0
            ],
            $this->array->getItems()
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
        $this->array[0] = 0;

        $this::assertSame(
            [
                0 => 0
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException('TypeError');

        $this->array['0'] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException('TypeError');

        $this->array[0] = '0';
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->array->setItem(0, 0);

        $this::assertSame(
            0,
            $this->array[0]
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException('TypeError');

        echo $this->array['0'];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->array->setItem(0, 0);

        $this->array->setItem(1, 1);

        unset($this->array[0]);

        $this::assertSame(
            [
                1 => 1
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException('TypeError');

        unset($this->array['0']);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->array->setItem(0, 0);

        $this::assertSame(
            true,
            isset($this->array[0])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException('TypeError');

        echo isset($this->array['0']);
    }

    //countable:

    public function testCountable(): void
    {
        $this->array->setItem(0, 0);

        $this::assertSame(
            1,
            count($this->array)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->array->setItem(0, 0);

        foreach ($this->array as $key => $value) {
            $this::assertSame(
                0,
                $key
            );
            $this::assertSame(
                0,
                $value
            );
        }
    }
}
