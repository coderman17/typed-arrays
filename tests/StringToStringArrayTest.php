<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\StringToStringArray;


final class StringToStringArrayTest extends TestCase
{
    //setItem:

    public function testSetItem(): void
    {
        $stringToStringArray = new StringToStringArray();
        $stringToStringArray->setItem('0', '0');
        $stringToStringArray->setItem('true', 'null');
        $stringToStringArray->setItem('a', '1.0');
        $stringToStringArray->setItem('2a', 'two');
        $stringToStringArray->setItem('3.7', 'false');
        $stringToStringArray->setItem('04', 'null');
        var_dump($stringToStringArray->getItems());
        $this::assertSame(
            ['0', 'true', 'a', '2a', '3.7', '04'],
            array_keys($stringToStringArray->getItems())
        );
        $this::assertSame(
            ['0', 'null', '1.0', 'two', 'false', 'null'],
            array_values($stringToStringArray->getItems())
        );
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToStringArray', 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToStringArray', 'setItem', 'value', $this),
            'string'
        );
    }
}
