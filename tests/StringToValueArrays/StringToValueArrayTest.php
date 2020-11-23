<?php

declare(strict_types = 1);

namespace Tests\StringToValueArrays;

use TypedArrays\StringToValueArrays\StringToValueArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

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

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->stringToValueArray->setItem('a', 0);
        $this->stringToValueArray->setItem('b', 1);
        $this->stringToValueArray->setItem('c', 2);

        unset($this->stringToValueArray['b']);

        $this::assertSame(
            $this->stringToValueArray->getItems(),
            [
                'a' => 0,
                'c' => 2
            ]
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
            $this->stringToValueArray['0'],
            0
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
            isset($this->stringToValueArray['0']),
            true
        );

        $this::assertSame(
            isset($this->stringToValueArray['1']),
            false
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this->stringToValueArray->setItem('0', 0);

        $this::expectException('TypeError');

        echo isset($this->stringToValueArray[0]);
    }
}
