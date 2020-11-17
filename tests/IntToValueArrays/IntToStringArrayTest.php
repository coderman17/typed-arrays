<?php

declare(strict_types = 1);

namespace Tests\IntToValueArrays;

use TypedArrays\IntToValueArrays\IntToStringArray;
use PHPUnit\Framework\TestCase;
use Tests\TestHelpers;

final class IntToStringArrayTest extends TestCase
{
    protected string $fullyQualifiedClassName;

    public function setUp(): void
    {
        parent::setUp();

        $this->fullyQualifiedClassName = 'TypedArrays\IntToValueArrays\IntToStringArray';
    }

    //unsetItem:

    public function testUnsetItem(): void
    {
        $intToStringArray = new IntToStringArray();
        $intToStringArray->setItem(0, '0');
        $intToStringArray->setItem(1, '1');
        $intToStringArray->setItem(2, '2');

        $intToStringArray->unsetItem(1);

        $this::assertSame(
            [
                0 => '0',
                2 => '2'
            ],
            $intToStringArray->getItems()
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
        $intToStringArray = new IntToStringArray();
        $intToStringArray->setItem(0, '0');
        $intToStringArray->setItem(1, '1.0');
        $intToStringArray->setItem(2, 'two');
        $intToStringArray->setItem(3, 'false');
        $intToStringArray->setItem(4, 'null');
        $this::assertSame(
            [
                0 => '0',
                1 => '1.0',
                2 => 'two',
                3 => 'false',
                4 => 'null'
            ],
            $intToStringArray->getItems()
        );
    }

    public function testSetItemKeyIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'key', $this),
            'int'
        );
    }

    public function testSetItemValueIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'setItem', 'value', $this),
            'string'
        );
    }

    //pushItem:

    public function testPushItem(): void
    {
        $intToStringArray = new IntToStringArray();
        $intToStringArray->pushItem('0');
        $this::assertSame(
            [
                0 => '0'
            ],
            $intToStringArray->getItems()
        );
    }

    public function testPushItemValueIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType($this->fullyQualifiedClassName, 'pushItem', 'value', $this),
            'string'
        );
    }
}