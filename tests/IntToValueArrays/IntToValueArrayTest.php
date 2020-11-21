<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToValueArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

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
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this),
            'int'
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
            $this->intToValueArray->getItems(),
            [
                0 => 0,
                2 => 2
            ]
        );
    }

    public function testOffsetUnsetKeyError(): void
    {
        $this->intToValueArray->setItem(0, 0);

        $this::expectException('TypeError');

        unset($this->intToValueArray['0']);
    }
}
