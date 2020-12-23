<?php /** @noinspection PhpExpressionResultUnusedInspection */

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToIntArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected IntToIntArray $array;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = IntToIntArray::class;

        $this->array = new IntToIntArray();
    }

    //setItem & getItems:

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

    //bulkSetItems on construct:
    public function testConstructorBulkSetItems(): void
    {
        $array = [
            0 => 0,
            1 => 1
        ];

        $newTypedArray = new IntToIntArray($array);

        $this::assertSame(
            $array,
            $newTypedArray->getItems()
        );
    }

    public function testArrayParamIsTypeArray(): void
    {
        $this::assertSame(
            'array',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, '__construct', 'array', $this)
        );
    }

    public function testConstructorArrayKeyError(): void
    {
        $array = [
            0 => 0,
            'b' => 1
        ];

        $this::expectException(\InvalidArgumentException::class);

        new IntToIntArray($array);
    }

    public function testConstructorArrayValueError(): void
    {
        $array = [
            0 => 0,
            1 => [
                1 => 1
            ]
        ];

        $this::expectException(\InvalidArgumentException::class);

        new IntToIntArray($array);
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
        $this::expectException(\InvalidArgumentException::class);

        $this->array['0'] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

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
        $this::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->array['0'];
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
        $this::expectException(\InvalidArgumentException::class);

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
