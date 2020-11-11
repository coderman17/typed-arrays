<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\StringToStringArray;


final class StringToStringArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $stringToStringArray = new StringToStringArray();
        $stringToStringArray->setItem('a1', 'a2');
        $stringToStringArray->setItem('b1', 'b2');
        $stringToStringArray->setItem('c1', 'c2');

        $stringToStringArray->unsetItem('b1');

        $this::assertSame(
            [
                'a1' => 'a2',
                'c1' => 'c2'
            ],
            $stringToStringArray->getItems()
        );
    }

    public function testUnsetItemKeyIsTypeString(): void
    {
        $this::assertSame(
            TestHelpers::getParameterType('TypedArrays\StringToStringArray', 'unsetItem', 'key', $this),
            'string'
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $stringToStringArray = new StringToStringArray();
        $stringToStringArray->setItem('0.1', '0.1');        //float from 0          ...as string
        $stringToStringArray->setItem('2.2', '2.2');        //float from >=1        ...as string
        $stringToStringArray->setItem('true', 'true');      //bool                  ...as string
        $stringToStringArray->setItem('false', 'false');    //bool                  ...as string
        $stringToStringArray->setItem('null', 'null');      //null                  ...as string
        $stringToStringArray->setItem('a', 'a');            //string                ...as string
        $stringToStringArray->setItem('2a', '2b');          //int-string            ...as string
        $stringToStringArray->setItem('a3', 'a3');          //string-int            ...as string
        $stringToStringArray->setItem('04', '04');          //int, leading zero     ...as string
        $stringToStringArray->setItem('0x05', '5');         //hexadecimal           ...as string
        $stringToStringArray->setItem('0b100', '4');        //binary                ...as string
        $stringToStringArray->setItem('-0', '-4');          //neg 0 (not cast)      ...as string
        $stringToStringArray->setItem('-0.5', '-4');        //neg float (not cast)  ...as string
        $stringToStringArray->setItem('-5.5', '-4');        //neg float (not cast)  ...as string

        foreach ($stringToStringArray->getItems() as $k => $v){
            $this::assertIsString($k);
            $this::assertIsString($v);
        }

        $this::expectException('Exception');
        $stringToStringArray->setItem('0', '0');            //zero int              ...as string

        $this::expectException('Exception');
        $stringToStringArray->setItem('4', '4');            //int                   ...as string

        $this::expectException('Exception');
        $stringToStringArray->setItem('400', '4');          //larger int            ...as string

        $this::expectException('Exception');
        $stringToStringArray->setItem('-4', '4');           //neg int               ...as string

        $this::expectException('Exception');
        $stringToStringArray->setItem('-400', '4');         //neg larger int        ...as string
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
