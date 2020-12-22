<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToStringArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected StringToStringArray $array;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = StringToStringArray::class;

        $this->array = new StringToStringArray();
    }

    //setItem & getItems:

    public function testSetItem(): void
    {
        $setMethod = function (string $key, string $value): void{
            $this->array->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, 'a', $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array->setItem($stringKey, 'a');
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsString($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
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
    //no need to test for numeric string key casting, as numeric strings will have already been int cast in the array
    public function testBulkSetItems(): void
    {
        $array = [
            'a' => 'a1',
            'b' => 'b1'
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
     * @psalm-suppress InvalidScalarArgument
     * @throws \Exception
     */
    public function testBulkSetItemsKeyError(): void
    {
        $array = [
            'a' => 'a1',
            1 => 'b'
        ];

        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line */
        $this->array->bulkSetItems($array);
    }

    /**
     * @psalm-suppress InvalidArgument
     * @throws \Exception
     */
    public function testBulkSetItemsValueError(): void
    {
        $array = [
            'a' => 'a1',
            'b' => [
                'b' => 'b1'
            ]
        ];

        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line */
        $this->array->bulkSetItems($array);
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->array->setItem('a', 'a1');

        $this->array->setItem('b', 'b1');

        $this->array->unsetItem('a');

        $this::assertSame(
            [
                'b' => 'b1'
            ],
            $this->array->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $offsetSetMethod = function (string $key, string $value): void{
            $this->array[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, 'a', $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array[$stringKey] = 'a';
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsString($v);
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->array[0] = '0';
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->array['a'] = 0;
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->array->setItem('a', 'a1');

        $this::assertSame(
            'a1',
            $this->array['a']
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->array[0];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->array->setItem('a', 'a1');

        $this->array->setItem('b', 'b1');

        unset($this->array['a']);

        $this::assertSame(
            [
                'b' => 'b1'
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        unset($this->array[0]);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->array->setItem('a', 'a1');

        $this::assertSame(
            true,
            isset($this->array['a'])
        );

        $this::assertSame(
            false,
            isset($this->array['b'])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        echo isset($this->array[0]);
    }

    //countable:

    public function testCountable(): void
    {
        $this->array->setItem('a', 'a1');

        $this::assertSame(
            1,
            count($this->array)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->array->setItem('a', 'a1');

        foreach ($this->array as $key => $value) {
            $this::assertSame(
                'a',
                $key
            );
            $this::assertSame(
                'a1',
                $value
            );
        }
    }
}
