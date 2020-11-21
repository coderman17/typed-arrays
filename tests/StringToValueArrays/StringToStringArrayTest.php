<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToStringArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToStringArray';
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToStringArray = new StringToStringArray();

        $setMethod = function ($key, $value) use ($stringToStringArray){
            $stringToStringArray->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, 'a', $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $stringToStringArray->setItem($stringKey, 'a');
        }

        foreach ($stringToStringArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsString($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this),
            'string'
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $stringToStringArray = new StringToStringArray();

        $offsetSetMethod = function ($key, $value) use ($stringToStringArray){
            $stringToStringArray[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, 'a', $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $stringToStringArray[$stringKey] = 'a';
        }

        foreach ($stringToStringArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsString($v);
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $stringToStringArray = new StringToStringArray();
        $this::expectException('TypeError');
        $stringToStringArray[0] = '0';
    }

    public function testOffsetSetValueError(): void
    {
        $stringToStringArray = new StringToStringArray();
        $this::expectException('TypeError');
        $stringToStringArray['0'] = 0;
    }
}
