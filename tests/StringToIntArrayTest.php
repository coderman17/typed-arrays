<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\StringToIntArray;


final class StringToIntArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $stringToIntArray = new StringToIntArray();
        $stringToIntArray->setItem('a1', 0);
        $stringToIntArray->setItem('b1', 1);
        $stringToIntArray->setItem('c1', 2);

        $stringToIntArray->unsetItem('b1');

        $this::assertSame(
            [
                'a1' => 0,
                'c1' => 2
            ],
            $stringToIntArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'unsetItem', 'key', $this),
            'string'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToIntArray = new StringToIntArray();
        //These tests check that PHP isn't quietly converting string keys to integers
        $stringToIntArray->setItem('0.1', 1);           //float from 0          ...as string
        $stringToIntArray->setItem('2.2', 2);           //float from >=1        ...as string
        $stringToIntArray->setItem('true', 1);          //bool                  ...as string
        $stringToIntArray->setItem('false', 0);         //bool                  ...as string
        $stringToIntArray->setItem('null', 1);          //null                  ...as string
        $stringToIntArray->setItem('a', 0);             //string                ...as string
        $stringToIntArray->setItem('2a', 2);            //int-string            ...as string
        $stringToIntArray->setItem('a3', 3);            //string-int            ...as string
        $stringToIntArray->setItem('04', 04);           //int, leading zero     ...as string
        $stringToIntArray->setItem('0x05', 5);          //hexadecimal           ...as string
        $stringToIntArray->setItem('0b100', 4);         //binary                ...as string
        $stringToIntArray->setItem('-0', -4);           //neg 0 (not cast)      ...as string
        $stringToIntArray->setItem('-0.5', -04);        //neg float (not cast)  ...as string
        $stringToIntArray->setItem('-5.5', -4);         //neg float (not cast)  ...as string

        foreach ($stringToIntArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsInt($v);
        }

        //These tests check an exception is thrown rather than letting PHP quietly convert string keys to integers
        $this::expectException('Exception');
        $stringToIntArray->setItem('0', 0);             //zero int              ...as string

        $this::expectException('Exception');
        $stringToIntArray->setItem('4', 4);             //int                   ...as string

        $this::expectException('Exception');
        $stringToIntArray->setItem('400', 4);           //larger int            ...as string

        $this::expectException('Exception');
        $stringToIntArray->setItem('-4', 4);            //neg int               ...as string

        $this::expectException('Exception');
        $stringToIntArray->setItem('-400', 4);          //neg larger int        ...as string
    }

    public function testSetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'setItem', 'key', $this),
            'string'
        );
    }

    public function testSetItemValueIsTypeInt(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToIntArray', 'setItem', 'value', $this),
            'int'
        );
    }
}
