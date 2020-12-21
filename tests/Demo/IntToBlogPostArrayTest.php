<?php

declare(strict_types = 1);

namespace Tests\Demo;

use PHPUnit\Framework\TestCase;
use TypedArrays\Demo\BlogPost;
use TypedArrays\Demo\IntToBlogPostArray;


final class IntToBlogPostArrayTest extends TestCase
{
    //unsetItem:

    public function testUnsetItem(): void
    {
        $a = new BlogPost('content1');
        $b = new BlogPost('content2');
        $c = new BlogPost('content3');

        $intToBlogPostArray = new IntToBlogPostArray();

        $intToBlogPostArray->setItem(0, $a);
        $intToBlogPostArray->setItem(1, $b);
        $intToBlogPostArray->setItem(2, $c);

        $intToBlogPostArray->unsetItem(1);

        $this::assertSame(
            [
                0 => $a,
                2 => $c
            ],
            $intToBlogPostArray->getItems()
        );
    }

    //setItem:

    public function testSetItem(): void
    {
        $a = new BlogPost('content1');

        $intToBlogPostArray = new IntToBlogPostArray();

        $intToBlogPostArray->setItem(0, $a);

        $this::assertSame(
            [
                0 => $a
            ],
            $intToBlogPostArray->getItems()
        );

        $this::expectException(\Exception::class);
        $intToBlogPostArray->setItem(0, new \stdClass());
    }

    //pushItem:

    public function testPushItem(): void
    {
        $a = new BlogPost('content1');

        $intToBlogPostArray = new IntToBlogPostArray();

        $intToBlogPostArray->pushItem($a);

        $this::assertSame(
            [
                0 => $a
            ],
            $intToBlogPostArray->getItems()
        );

        $this::expectException(\Exception::class);
        $intToBlogPostArray->pushItem(new \stdClass());
    }
}
