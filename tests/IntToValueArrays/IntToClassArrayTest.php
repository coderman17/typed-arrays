<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToClassArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToClassArray';
    }

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
            'int',
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
            'object',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'pushItem', 'value', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $extendsIntToClassArray[0] = $a;

        $this::assertSame(
            [
                0 => $a
            ],
            $extendsIntToClassArray->getItems()
        );
    }


    public function testOffsetSetKeyError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $this::expectException('TypeError');

        $extendsIntToClassArray['0'] = $a;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $this::expectException('TypeError');

        $extendsIntToClassArray[0] = true;
    }

    public function testOffsetSetValueClassError(): void
    {
        $testClass = new class {};

        $a = new $testClass();

        $extendsIntToClassArray = $this->extendIntToClassArray($a);

        $this::expectException('TypeError');

        $extendsIntToClassArray[0] = new \stdClass();
    }
}
