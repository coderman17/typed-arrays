<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use Tests\TestHelpers;
use TypedArrays\IntToValueArrays\IntToValueArray;
use PHPUnit\Framework\TestCase;

final class IntToValueArrayTest extends TestCase
{
    protected IntToValueArray $intToValueArray;

    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->intToValueArray = new class extends IntToValueArray{
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

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToValueArray';
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $this->intToValueArray->setItem(0, 0);
        $this->intToValueArray->setItem(1, 1);
        $this->intToValueArray->setItem(2, 2);

        $this->intToValueArray->unsetItem(1);

        $this::assertSame(
            [
                0 => 0,
                2 => 2
            ],
            $this->intToValueArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            'int',
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this)
        );
    }

    //offsetUnset:

    public function testOffsetUnset(): void
    {
        $this->intToValueArray->setItem(0, 0);
        $this->intToValueArray->setItem(1, 1);
        $this->intToValueArray->setItem(2, 2);

        unset($this->intToValueArray[1]);

        $this::assertSame(
            [
                0 => 0,
                2 => 2
            ],
            $this->intToValueArray->getItems()
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::expectException('TypeError');

        unset($this->intToValueArray['0']);
    }

    //offsetGet:

    public function testOffsetGet(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::assertSame(
            0,
            $this->intToValueArray[0]
        );
    }

    public function testOffsetGetKeyError(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::expectException('TypeError');

        $this->intToValueArray['0'];
    }

    //offsetExists:

    public function testOffsetExists(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::assertSame(
            true,
            isset($this->intToValueArray[0])
        );

        $this::assertSame(
            false,
            isset($this->intToValueArray[1])
        );
    }

    public function testOffsetExistsKeyError(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::expectException('TypeError');

        echo isset($this->intToValueArray['0']);
    }
}
