<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToClassArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    protected string $permittedClass;

    protected object $permittedClassObject;

    protected StringToClassArray $extendsTypedArray;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToClassArray';

        $this->permittedClassObject = new class {};

        $this->permittedClass = get_class($this->permittedClassObject);

        //This sets the className property on construction only for testing purposes
        //A genuine extending class of StringToClassArray would rightly have this hardcoded
        $this->extendsTypedArray = new class($this->permittedClass) extends StringToClassArray
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
        $setMethod = function ($key, $value){
            $this->extendsTypedArray->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, $this->permittedClassObject, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->extendsTypedArray->setItem($stringKey, $this->permittedClassObject);
        }

        foreach ($this->extendsTypedArray->getItems() as $k => $v){
            $this::assertIsString($k);

            $this::assertSame(
                $this->permittedClass,
                get_class($v)
            );
        }
    }

    public function testSetItemValueError(): void
    {
        $this::expectException('TypeError');

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

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = new $this->permittedClassObject();

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
        $offsetSetMethod = function ($key, $value){
            $this->extendsTypedArray[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, $this->permittedClassObject, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->extendsTypedArray[$stringKey] = $this->permittedClassObject;
        }

        foreach ($this->extendsTypedArray->getItems() as $k => $v){
            $this::assertIsString($k);

            $this::assertSame(
                $this->permittedClass,
                get_class($v)
            );
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray[0] = $this->permittedClassObject;
    }

    public function testOffsetSetValueTypeError(): void
    {
        $this::expectException('TypeError');

        $this->extendsTypedArray['a'] = true;
    }

    public function testOffsetSetValueClassError(): void
    {
        $this::expectException('TypeError');

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
        $this::expectException('TypeError');

        echo $this->extendsTypedArray[0];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = new $this->permittedClassObject();

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
        $this::expectException('TypeError');

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
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException('TypeError');

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
            $this::assertSame(
                $this->permittedClassObject,
                $value
            );
        }
    }
}
