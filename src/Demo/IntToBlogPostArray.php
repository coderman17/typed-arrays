<?php

declare(strict_types = 1);

namespace TypedArrays\Demo;

use TypedArrays\IntToValueArrays\IntToClassArray;

class IntToBlogPostArray extends IntToClassArray
{
    protected string $className = 'TypedArrays\Demo\BlogPost';
}
