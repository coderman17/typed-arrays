<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToClassArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

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

        $this->permittedClassObject = TestHelpers::generateAnonClassObject();

        $this->permittedClass = get_class($this->permittedClassObject);

        //This sets the className property on construction only for testing purposes
        //A genuine extending class of StringToClassArray would rightly have this hardcoded
        $this->extendsTypedArray = new class($this->permittedClass) extends StringToClassArray
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
        $this::expectException(\Exception::class);

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

    //bulkSetItems:
    public function testBulkSetItems(): void
    {
        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            'b' => $secondPermittedClassObject
        ];

        $this->extendsTypedArray->bulkSetItems($array);

        $this::assertSame(
            $array,
            $this->extendsTypedArray->getItems()
        );
    }

    public function testBulkSetItemsParamIsTypeArray(): void
    {
        $this::assertSame(
            'array',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'bulkSetItems', 'array', $this)
        );
    }

    /**
     * @psalm-suppress InvalidScalarArgument
     * @throws \Exception
     */
    public function testBulkSetItemsKeyError(): void
    {
        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            1 => $secondPermittedClassObject
        ];

        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line */
        $this->extendsTypedArray->bulkSetItems($array);
    }

    public function testBulkSetItemsClassError(): void
    {
        $array = [
            'a' => $this->permittedClassObject,
            'b' => new \stdClass()
        ];

        $this::expectException(\Exception::class);

        $this->extendsTypedArray->bulkSetItems($array);
    }

    /**
     * @psalm-suppress InvalidArgument
     * @throws \Exception
     */
    public function testBulkSetItemsValueError(): void
    {
        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

        $array = [
            'a' => $this->permittedClassObject,
            'b' => [
                'b' => $secondPermittedClassObject
            ]
        ];

        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line */
        $this->extendsTypedArray->bulkSetItems($array);
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

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
        $this::expectException(\TypeError::class);

        $this->extendsTypedArray[0] = $this->permittedClassObject;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\TypeError::class);

        $this->extendsTypedArray['a'] = true;
    }

    public function testOffsetSetClassError(): void
    {
        $this::expectException(\Exception::class);

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
        $this::expectException(\TypeError::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->extendsTypedArray[0];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->extendsTypedArray->setItem('a', $this->permittedClassObject);

        $secondPermittedClassObject = TestHelpers::generateAnonClassObject();

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
        $this::expectException(\TypeError::class);

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
        $this::expectException(\TypeError::class);

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
