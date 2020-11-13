<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\IntToClassArray;


final class IntToClassArrayTest extends TestCase
{
    //This sets className property automatically only for testing purposes
    protected function extendIntToClassArray(object $obj): object
    {
        return new class($obj) extends IntToClassArray
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

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $extendsIntToClassArray->setItem(0, $a);
        $extendsIntToClassArray->setItem(1, $b);
        $extendsIntToClassArray->setItem(2, $c);

        $extendsIntToClassArray->unsetItem(1);

        $this::assertSame(
            [
                0 => $a,
                2 => $c
            ],
            $extendsIntToClassArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntToClassArray', 'unsetItem', 'key', $this),
            'int'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $extendsIntToClassArray->setItem(0, $a);

        $this::assertSame(
            [
                0 => $a
            ],
            $extendsIntToClassArray->getItems()
        );

        $this::expectException('TypeError');
        $extendsIntToClassArray->setItem(0, new \stdClass());
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntToClassArray', 'setItem', 'key', $this),
            'int'
        );
    }

    public function testSetItemValueIsTypeObject(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntToClassArray', 'setItem', 'value', $this),
            'object'
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $extendsIntToClassArray->pushItem($a);

        $this::assertSame(
            [
                0 => $a
            ],
            $extendsIntToClassArray->getItems()
        );

        $this::expectException('TypeError');
        $extendsIntToClassArray->pushItem(new \stdClass());
    }

    public function testPushItemValueIsTypeObject(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\IntToClassArray', 'pushItem', 'value', $this),
            'object'
        );
    }
}
