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

    //unsetItem:

    public function testUnsetItem(): void
    {
        $stringToStringArray = new StringToStringArray();
        $stringToStringArray->setItem('a1', 'a2');
        $stringToStringArray->setItem('b1', 'b2');
        $stringToStringArray->setItem('c1', 'c2');

        $stringToStringArray->unsetItem('b1');

        $this::assertSame(
            [
                'a1' => 'a2',
                'c1' => 'c2'
            ],
            $stringToStringArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this),
            'string'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToStringArray = new StringToStringArray();

        //This test checks an exception is thrown rather than letting PHP quietly convert string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_CAST_AS_INT as $stringKey){
            TestHelpers::expectExceptionOnSetItem($stringToStringArray, $stringKey, 'a', $this);
        }

        $this::assertSame(
            $stringToStringArray->getItems(),
            []
        );

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
}
