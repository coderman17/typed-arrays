<?php

declare(strict_types = 1);

namespace Tests\Demo;

use PHPUnit\Framework\TestCase;
use TypedArrays\Demo\BlogPost;
use TypedArrays\Demo\IntToBlogPostArray;


final class IntToBlogPostArrayTest extends TestCase
{
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

        $this::expectException('TypeError');
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

        $this::expectException('TypeError');
        $intToBlogPostArray->pushItem(new \stdClass());
    }
}
