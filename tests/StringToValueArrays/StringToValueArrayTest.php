<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use Tests\TestHelpers;
use TypedArrays\StringToValueArrays\StringToValueArray;
use PHPUnit\Framework\TestCase;

final class StringToValueArrayTest extends TestCase
{
    protected StringToValueArray $stringToValueArray;

    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->stringToValueArray = new class extends StringToValueArray{
            /**
             * @param $key
             * @param $value
             */
            public function setItem($key, $value){
                $this->items[$key] = $value;
            }

            /**
             * @param $key
             * @param $value
             */
            public function offsetSet($key, $value){}
        };

        $this->fullyQualifiedClassName = 'TypedArrays\StringToValueArrays\StringToValueArray';
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->stringToValueArray->setItem('a', 0);
        $this->stringToValueArray->setItem('b', 1);
        $this->stringToValueArray->setItem('c', 2);

        $this->stringToValueArray->unsetItem('b');

        $this::assertSame(
            [
                'a' => 0,
                'c' => 2
            ],
            $this->stringToValueArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            'string',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
        );
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->stringToValueArray->setItem('a', 0);
        $this->stringToValueArray->setItem('b', 1);
        $this->stringToValueArray->setItem('c', 2);

        unset($this->stringToValueArray['b']);

        $this::assertSame(
            [
                'a' => 0,
                'c' => 2
            ],
            $this->stringToValueArray->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::expectException('TypeError');

        unset($this->stringToValueArray[0]);
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::assertSame(
            0,
            $this->stringToValueArray['0']
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::expectException('TypeError');

        $this->stringToValueArray[0];
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::assertSame(
            true,
            isset($this->stringToValueArray['0'])
        );

        $this::assertSame(
            false,
            isset($this->stringToValueArray['1'])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::expectException('TypeError');

        echo isset($this->stringToValueArray[0]);
    }
}
