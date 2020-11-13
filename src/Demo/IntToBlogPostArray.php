<?php

declare(strict_types = 1);

namespace TypedArrays\Demo;

use TypedArrays\IntToClassArray;

class IntToBlogPostArray extends IntToClassArray
{
    protected string $className = 'TypedArrays\Demo\BlogPost';
}
