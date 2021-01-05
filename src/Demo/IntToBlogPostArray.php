<?php

declare(strict_types = 1);

namespace TypedArrays\Demo;

use TypedArrays\IntToClassArray;

class IntToBlogPostArray extends IntToClassArray
{
    protected function getClassName(): string
    {
        return BlogPost::class;
    }
}
