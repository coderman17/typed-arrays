<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToClassArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected string $permittedClass;

    protected object $permittedClassObject;

    protected IntToClassArray $extendsTypedArray;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToClassArray';

        $this->permittedClassObject = new class {};

        $this->permittedClass = get_class($this->permittedClassObject);

        //This sets the className property on construction only for testing purposes
        //A genuine extending class of IntToClassArray would rightly have this hardcoded
        $this->extendsTypedArray = new class($this->permittedClass) extends IntToClassArray
        {
            protected string $className;

            public function __construct(string $className)
            {
                $this->className = $className;
            }
        };
    }

    //setItem:

    public function testSetItem(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $this::assertSame(
            [
                0 => $this->permittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testSetItemValueError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray->setItem(0, new \stdClass());
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
        $this->extendsTypedArray->pushItem($this->permittedClassObject);

        $this::assertSame(
            [
                0 => $this->permittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testPushItemValueError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray->pushItem(new \stdClass());
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
        $this->extendsTypedArray[0] = $this->permittedClassObject;

        $this::assertSame(
            [
                0 => $this->permittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }


    public function testOffsetSetKeyError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray['0'] = $this->permittedClassObject;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray[0] = true;
    }

    public function testOffsetSetValueClassError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray[0] = new \stdClass();
    }
}
