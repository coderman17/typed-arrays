<?php

declare(strict_types = 1);

namespace TypedArrays\Demo;

class BlogPost
{
    protected string $content;

    public function __construct(string $contents)
    {
        $this->content = $contents;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}