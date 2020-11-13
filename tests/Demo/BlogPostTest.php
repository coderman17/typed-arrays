<?php

declare(strict_types = 1);

namespace Tests\Demo;

use PHPUnit\Framework\TestCase;
use TypedArrays\Demo\BlogPost;


final class BlogPostTest extends TestCase
{
    //construct with contents, then get contents:

    public function testBlogPostConstructor(): void
    {
        $content = 'Testing material';
        $blogPost = new BlogPost($content);

        $this::assertSame(
            $content,
            $blogPost->getContent()
        );
    }
}
