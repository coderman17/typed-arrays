<?php /** @noinspection PhpExpressionResultUnusedInspection */

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class StringToIntArrayTest extends TestCase
{
    /**
     * @var class-string
     */
    protected string $fullyQualifiedClassName;

    protected StringToIntArray $array;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = StringToIntArray::class;

        $this->array = new StringToIntArray();
    }

    //setItem & getItems:

    public function testSetItem(): void
    {
        $setMethod = function (string $key, int $value): void {
            $this->array->setItem($key, $value);
        };

        TestHelpers::checkForSilentKeyTypeCastingException($setMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array->setItem($stringKey, 0);
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this)
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this)
        );
    }

    //bulkSetItems on construct:
    //no need to test for numeric string key casting, as numeric strings will have already been int cast in the array
    public function testConstructorBulkSetItems(): void
    {
        $array = [
            'a' => 0,
            'b' => 1
        ];

        $newTypedArray = new StringToIntArray($array);

        $this::assertSame(
            $array,
            $newTypedArray->getItems()
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
        $array = [
            'a' => 0,
            1 => 1
        ];

        $this::expectException(\InvalidArgumentException::class);

        new StringToIntArray($array);
    }

    public function testConstructorArrayValueError(): void
    {
        $array = [
            'a' => 0,
            'b' => [
                'b' => 1
            ]
        ];

        $this::expectException(\InvalidArgumentException::class);

        new StringToIntArray($array);
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->array->setItem('a', 0);

        $this->array->setItem('b', 1);

        $this->array->unsetItem('a');

        $this::assertSame(
            [
                'b' => 1
            ],
            $this->array->getItems()
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
        $offsetSetMethod = function (string $key, int $value): void{
            $this->array[$key] = $value;
        };

        TestHelpers::checkForSilentKeyTypeCastingException($offsetSetMethod, 0, $this);

        //These tests check that PHP isn't quietly converting string keys to integers
        foreach (TestHelpers::STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT as $stringKey){
            $this->array[$stringKey] = 0;
        }

        foreach ($this->array->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }
    }

    public function testOffsetSetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->array[0] = 0;
    }

    public function testOffsetSetValueError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        $this->array['a'] = '0';
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->array->setItem('a', 0);

        $this::assertSame(
            0,
            $this->array['a']
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line it's fine that it doesn't do anything*/
        $this->array[0];
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->array->setItem('a', 0);

        $this->array->setItem('b', 1);

        unset($this->array['a']);

        $this::assertSame(
            [
                'b' => 1
            ],
            $this->array->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        unset($this->array[0]);
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->array->setItem('a', 0);

        $this::assertSame(
            true,
            isset($this->array['a'])
        );

        $this::assertSame(
            false,
            isset($this->array['b'])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this::expectException(\InvalidArgumentException::class);

        echo isset($this->array[0]);
    }

    //countable:

    public function testCountable(): void
    {
        $this->array->setItem('a', 0);

        $this::assertSame(
            1,
            count($this->array)
        );
    }

    //Iterator:

    public function testIterator(): void
    {
        $this->array->setItem('a', 0);

        foreach ($this->array as $key => $value) {
            $this::assertSame(
                'a',
                $key
            );
            $this::assertSame(
                0,
                $value
            );
        }
    }
}
