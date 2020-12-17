<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToIntArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected StringToIntArray $array;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToIntArray';

        $this->array = new StringToIntArray();
    }

    //setItem:

    public function testSetItem(): void
    {
        $setMethod = function ($key, $value){
            $this->array->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array->setItem($stringKey, 0);
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
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

    //offsetSet:

    public function testOffsetSet(): void
    {
        $offsetSetMethod = function ($key, $value){
            $this->array[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array[$stringKey] = 0;
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException('TypeError');

        $this->array[0] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException('TypeError');

        $this->array['a'] = '0';
    }
}
