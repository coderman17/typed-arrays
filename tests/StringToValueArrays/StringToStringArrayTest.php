<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToStringArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected StringToStringArray $array;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToStringArray';

        $this->array = new StringToStringArray();
    }

    //setItem & getItems:

    public function testSetItem(): void
    {
        $setMethod = function ($key, $value){
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
        $offsetSetMethod = function ($key, $value){
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
        $this::expectException('TypeError');

        $this->array[0] = '0';
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException('TypeError');

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
        $this::expectException('TypeError');

        echo $this->array[0];
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
        $this::expectException('TypeError');

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
        $this::expectException('TypeError');

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
