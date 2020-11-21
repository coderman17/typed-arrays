<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToIntArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToIntArray';
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToIntArray = new StringToIntArray();

        $setMethod = function ($key, $value) use ($stringToIntArray){
            $stringToIntArray->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $stringToIntArray->setItem($stringKey, 0);
        }

        foreach ($stringToIntArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this),
            'int'
        );
    }

    //offsetSet:

    public function testoffsetSet(): void
    {
        $stringToIntArray = new StringToIntArray();

        $offsetSetMethod = function ($key, $value) use ($stringToIntArray){
            $stringToIntArray[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $stringToIntArray[$stringKey] = 0;
        }

        foreach ($stringToIntArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $stringToIntArray = new StringToIntArray();
        $this::expectException('TypeError');
        $stringToIntArray[0] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $stringToIntArray = new StringToIntArray();
        $this::expectException('TypeError');
        $stringToIntArray['a'] = '0';
    }
}
