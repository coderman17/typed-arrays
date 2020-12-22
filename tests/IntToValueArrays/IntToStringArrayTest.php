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

    //bulkSetItems:
    public function testBulkSetItems(): void
    {
        $array = [
            0 => 'a',
            1 => 'b'
        ];

        $this->array->bulkSetItems($array);

        $this::assertSame(
            $array,
            $this->array->getItems()
        );
    }

    public function testBulkSetItemsParamIsTypeArray(): void
    {
        $this::assertSame(
            'array',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'bulkSetItems', 'array', $this)
        );
    }

    /**
     * @throws \Exception
     */
    public function testBulkSetItemsKeyError(): void
    {
        $array = [
            0 => 'a',
            'b' => 'b1'
        ];

        $this::expectException(\InvalidArgumentException::class);

        $this->array->bulkSetItems($array);
    }

    /**
     * @throws \Exception
     */
    public function testBulkSetItemsValueError(): void
    {
        $array = [
            0 => 'a',
            1 => [
                1 => 'b'
            ]
        ];

        $this::expectException(\InvalidArgumentException::class);

        $this->array->bulkSetItems($array);
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
        $this::expectException(\InvalidArgumentException::class);

        $this->array['0'] = 'a';
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

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
        $this::expectException(\InvalidArgumentException::class);

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
        $this::expectException(\InvalidArgumentException::class);

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
        $this::expectException(\InvalidArgumentException::class);

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
