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
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this),
            'string'
        );
    }
}
