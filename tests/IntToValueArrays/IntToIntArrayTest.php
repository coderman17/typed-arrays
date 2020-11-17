<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToIntArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToIntArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToIntArray';
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $intToIntArray = new IntToIntArray();
        $intToIntArray->setItem(0, 0);
        $intToIntArray->setItem(1, 1);
        $intToIntArray->setItem(2, 2);

        $intToIntArray->unsetItem(1);

        $this::assertSame(
            [
                0 => 0,
                2 => 2
            ],
            $intToIntArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'unsetItem', 'key', $this),
            'int'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $intToIntArray = new IntToIntArray();
        $intToIntArray->setItem(0, 0);
        $this::assertSame(
            [
                0 => 0
            ],
            $intToIntArray->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this),
            'int'
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this),
            'int'
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $intToIntArray = new IntToIntArray();
        $intToIntArray->pushItem(0);
        $this::assertSame(
            [
                0 => 0
            ],
            $intToIntArray->getItems()
        );
    }

    public function testPushItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'pushItem', 'value', $this),
            'int'
        );
    }
}