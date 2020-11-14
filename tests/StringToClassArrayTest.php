<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\StringToClassArray;


final class StringToClassArrayTest extends TestCase
{
    //This sets className property automatically only for testing purposes
    protected function extendStringToClassArray(object $obj): object
    {
        return new class($obj) extends StringToClassArray
        {
            protected string $className;

            public function __construct(object $obj)
            {
                $this->className = get_class($obj);
            }
        };
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $testClass = new class {};

        $a = new $testClass();
        $b = new $testClass();
        $c = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $extendsStringToClassArray->setItem('a', $a);
        $extendsStringToClassArray->setItem('b', $b);
        $extendsStringToClassArray->setItem('c', $c);

        $extendsStringToClassArray->unsetItem('b');

        $this::assertSame(
            [
                'a' => $a,
                'c' => $c
            ],
            $extendsStringToClassArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToClassArray', 'unsetItem', 'key', $this),
            'string'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        //This test checks an exception is thrown rather than letting PHP quietly convert string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_CAST_AS_INT as $stringKey){
            TestHelpers::expectExceptionOnSetItem($extendsStringToClassArray, $stringKey, $a, $this);
        }

        $this::assertSame(
            $extendsStringToClassArray->getItems(),
            []
        );

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $extendsStringToClassArray->setItem($stringKey, $a);
        }

        foreach ($extendsStringToClassArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsObject($v);
        }

        //This test checks a TypeError exception is thrown if the wrong class is passed to setItem()
        $this::expectException('TypeError');
        $extendsStringToClassArray->setItem('a', new \stdClass());
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToClassArray', 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeObject(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToClassArray', 'setItem', 'value', $this),
            'object'
        );
    }
}
