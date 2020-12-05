<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToClassArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToClassArray';
    }

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

    //setItem:

    public function testSetItem(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $setMethod = function ($key, $value) use ($extendsStringToClassArray){
            $extendsStringToClassArray->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, $a, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $extendsStringToClassArray->setItem($stringKey, $a);
        }

        $expectedClass = get_class($a);

        foreach ($extendsStringToClassArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertSame(
                $expectedClass,
                get_class($v)
            );
        }

        //This test checks a TypeError exception is thrown if the wrong class is passed to setItem()
        $this::expectException('TypeError');
        $extendsStringToClassArray->setItem('a', new \stdClass());
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this)
        );
    }

    public function testSetItemValueIsTypeObject(): void
    {
        $this::assertSame(
            'object',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $offsetSetMethod = function ($key, $value) use ($extendsStringToClassArray){
            $extendsStringToClassArray[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, $a, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $extendsStringToClassArray[$stringKey] = $a;
        }

        $expectedClass = get_class($a);

        foreach ($extendsStringToClassArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertSame(
                $expectedClass,
                get_class($v)
            );
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $this::expectException('TypeError');

        $extendsStringToClassArray[0] = $a;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $this::expectException('TypeError');

        $extendsStringToClassArray['a'] = true;
    }

    public function testOffsetSetValueClassError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsStringToClassArray = $this->extendStringToClassArray($a);

        $this::expectException('TypeError');

        $extendsStringToClassArray['a'] = new \stdClass();
    }
}
