<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToClassArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected string $permittedClass;

    protected object $permittedClassObject;

    protected IntToClassArray $extendsTypedArray;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = IntToClassArray::class;

        $this->permittedClassObject = TestHelpers::generateAnonClassObject();

        $this->permittedClass = get_class($this->permittedClassObject);

        //This sets the className property on construction only for testing purposes
        //A genuine extending class of IntToClassArray would rightly have this hardcoded
        $this->extendsTypedArray = new class($this->permittedClass) extends IntToClassArray
        {
            protected string $className;

            public function __construct(string $className)
            {
                $this->className = $className;

                parent::__construct();
            }

            /**
             * @return class-string
             *
             * It's not possible to generate a class-string from an anonymous class:
             * @psalm-suppress MoreSpecificReturnType
             * @psalm-suppress LessSpecificReturnStatement
             * @
             */
            protected function getClassName(): string
            {
                /** @phpstan-ignore-next-line */
                return $this->className;
            }
        };
    }

    //setItem & getItems:

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

    public function testSetItemClassError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

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

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

        $this->extendsTypedArray->setItem(1, $secondPermittedClassObject);

        $this->extendsTypedArray->unsetItem(0);

        $this::assertSame(
            [
                1 => $secondPermittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
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
        $this::expectException(\InvalidArgumentException::class);

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
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray['0'] = $this->permittedClassObject;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray[0] = true;
    }

    public function testOffsetSetClassError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray[0] = new \stdClass();
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $this::assertSame(
            $this->permittedClassObject,
            $this->extendsTypedArray[0]
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->extendsTypedArray['0'];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

        $this->extendsTypedArray->setItem(1, $secondPermittedClassObject);

        unset($this->extendsTypedArray[0]);

        $this::assertSame(
            [
                1 => $secondPermittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        unset($this->extendsTypedArray['0']);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $this::assertSame(
            true,
            isset($this->extendsTypedArray[0])
        );

        $this::assertSame(
            false,
            isset($this->extendsTypedArray[1])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        echo isset($this->extendsTypedArray['0']);
    }

    //countable:

    public function testCountable(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        $this::assertSame(
            1,
            count($this->extendsTypedArray)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->extendsTypedArray->setItem(0, $this->permittedClassObject);

        foreach ($this->extendsTypedArray as $key => $value) {
            $this::assertSame(
                0,
                $key
            );

            if(!is_object($value)){
                $this::fail('Unexpected non-object found');
            }

            $this::assertSame(
                $this->permittedClassObject,
                $value
            );
        }
    }
}
