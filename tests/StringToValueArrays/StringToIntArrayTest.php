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

        //This test checks an exception is thrown rather than letting PHP quietly convert string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_CAST_AS_INT as $stringKey){
            TestHelpers::expectExceptionOnSetItem($stringToIntArray, $stringKey, 0, $this);
        }

        $this::assertSame(
            $stringToIntArray->getItems(),
            []
        );

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
}
