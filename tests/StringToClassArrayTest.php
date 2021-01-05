<?php

declare(strict_types = 1);

namespace Tests;

use TypedArrays\StringToClassArray;
use PHPUnit\Framework\TestCase;

final class StringToClassArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected string $permittedClass;

    protected object $permittedClassObject;

    protected StringToClassArray $extendsTypedArray;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = StringToClassArray::class;

        $this->permittedClassObject = TestHelpers::newEmptyClassObject();

        $this->permittedClass = get_class($this->permittedClassObject);

        $this->extendsTypedArray = $this->newExtendingClassObject($this->permittedClass);
    }

    //This sets the className property on construction only for testing purposes
    //A genuine extending class of StringToClassArray would rightly have this hardcoded
    protected function newExtendingClassObject(string $permittedClass, array $array = null): StringToClassArray
    {
        return new class($permittedClass, $array) extends StringToClassArray
        {
            protected string $className;

            public function __construct(string $className, array $array = null)
            {
                $this->className = $className;

                parent::__construct($array);
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
        $setMethod = function (string $key, object $value): void {
            $this->extendsTypedArray->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, $this->permittedClassObject, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->extendsTypedArray->setItem($stringKey, $this->permittedClassObject);
        }

        foreach ($this->extendsTypedArray->getItems() as $key => $value){
            $this::assertIsString($key);

            if(!is_object($value)){
                $this::fail('Unexpected non-object found');
            }

            $this::assertSame(
                $this->permittedClass,
                get_class($value)
            );
        }
    }

    public function testSetItemClassError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray->setItem('a', new \stdClass());
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

    //bulkSetItems on construct:
    //no need to test for numeric string key casting, as numeric strings will have already been int cast in the array
    public function testConstructorBulkSetItems(): void
    {
        $secondPermittedClassObject = TestHelpers::newEmptyClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            'b' => $secondPermittedClassObject
        ];

        $extendsTypedArray = $this->newExtendingClassObject($this->permittedClass, $array);

        $this::assertSame(
            $array,
            $extendsTypedArray->getItems()
        );
    }

    public function testArrayParamIsTypeArray(): void
    {
        $this::assertSame(
            'array',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, '__construct', 'array', $this)
        );
    }

    public function testConstructorArrayKeyError(): void
    {
        $secondPermittedClassObject = TestHelpers::newEmptyClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            1 => $secondPermittedClassObject
        ];

        $this::expectException(\InvalidArgumentException::class);

        $this->newExtendingClassObject($this->permittedClass, $array);
    }

    public function testConstructorArrayClassError(): void
    {
        $array = [
            'a' => $this->permittedClassObject,
            'b' => new \stdClass()
        ];

        $this::expectException(\InvalidArgumentException::class);

        $this->newExtendingClassObject($this->permittedClass, $array);
    }

    public function testConstructorArrayValueError(): void
    {
        $secondPermittedClassObject = TestHelpers::newEmptyClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            'b' => [
                'b' => $secondPermittedClassObject
            ]
        ];

        $this::expectException(\InvalidArgumentException::class);

        $this->newExtendingClassObject($this->permittedClass, $array);
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::newEmptyClassObject();

        $this->extendsTypedArray->setItem('b', $secondPermittedClassObject);

        $this->extendsTypedArray->unsetItem('a');

        $this::assertSame(
            [
                'b' => $secondPermittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
        );
    }

    //offsetSet:

    public function testOffsetSet(): void
    {
        $offsetSetMethod = function (string $key, object $value): void {
            $this->extendsTypedArray[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, $this->permittedClassObject, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->extendsTypedArray[$stringKey] = $this->permittedClassObject;
        }

        foreach ($this->extendsTypedArray->getItems() as $key => $value){
            $this::assertIsString($key);

            if(!is_object($value)){
                $this::fail('Unexpected non-object found');
            }

            $this::assertSame(
                $this->permittedClass,
                get_class($value)
            );
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray[0] = $this->permittedClassObject;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray['a'] = true;
    }

    public function testOffsetSetClassError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->extendsTypedArray['a'] = new \stdClass();
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $this::assertSame(
            $this->permittedClassObject,
            $this->extendsTypedArray['a']
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->extendsTypedArray[0];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::newEmptyClassObject();

        $this->extendsTypedArray->setItem('b', $secondPermittedClassObject);

        unset($this->extendsTypedArray['a']);

        $this::assertSame(
            [
                'b' => $secondPermittedClassObject
            ],
            $this->extendsTypedArray->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        unset($this->extendsTypedArray[0]);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $this::assertSame(
            true,
            isset($this->extendsTypedArray['a'])
        );

        $this::assertSame(
            false,
            isset($this->extendsTypedArray['b'])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        echo isset($this->extendsTypedArray[0]);
    }

    //countable:

    public function testCountable(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $this::assertSame(
            1,
            count($this->extendsTypedArray)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        foreach ($this->extendsTypedArray as $key => $value) {
            $this::assertSame(
                'a',
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
