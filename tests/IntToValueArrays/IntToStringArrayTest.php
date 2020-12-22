<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToStringArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected IntToStringArray $array;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = IntToStringArray::class;

        $this->array = new IntToStringArray();
    }

    //setItem & getItems:

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

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->array->setItem(0, 'a');

        $this->array->setItem(1, 'b');

        $this->array->unsetItem(0);

        $this::assertSame(
            [
                1 => 'b'
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
        $this::expectException(\TypeError::class);

        $this->array['0'] = 'a';
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\TypeError::class);

        $this->array[0] = 0;
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->array->setItem(0, 'a');

        $this::assertSame(
            'a',
            $this->array[0]
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->array['0'];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->array->setItem(0, 'a');

        $this->array->setItem(1, 'b');

        unset($this->array[0]);

        $this::assertSame(
            [
                1 => 'b'
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException(\TypeError::class);

        unset($this->array['0']);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->array->setItem(0, 'a');

        $this::assertSame(
            true,
            isset($this->array[0])
        );

        $this::assertSame(
            false,
            isset($this->array[1])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException(\TypeError::class);

        echo isset($this->array['0']);
    }

    //countable:

    public function testCountable(): void
    {
        $this->array->setItem(0, 'a');

        $this::assertSame(
            1,
            count($this->array)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->array->setItem(0, 'a');

        foreach ($this->array as $key => $value) {
            $this::assertSame(
                0,
                $key
            );
            $this::assertSame(
                'a',
                $value
            );
        }
    }
}
