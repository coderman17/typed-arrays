<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use TypedArrays\Demo\IntToBlogPostArray;
use TypedArrays\Demo\BlogPost;


//Function declares type of array object required
function greet_from_blog_posts (IntToBlogPostArray $intToBlogPostArray): void
{
    //The IntToBlogPostArray object can be used like an array in a foreach loop
    foreach ($intToBlogPostArray as $blogPost){
        echo $blogPost->getContent() . "\n";
    }


    //Or, the array can be retrieved as a whole via getItems()
    $blogPosts = $intToBlogPostArray->getItems();
}


//Make new Array object
$intToBlogPostArray = new IntToBlogPostArray();


//Can add objects of correct class successfully:
//via pushItem()
$intToBlogPostArray->pushItem(new BlogPost('This is a blog post about cats'));
//or, via setItem() to specify the key too
$intToBlogPostArray->setItem(1, new BlogPost('This is a blog post about food'));


//Pass array to function with full type hinting
greet_from_blog_posts($intToBlogPostArray);


//Exception because of wrong class:
//$intToBlogPostArray->pushItem(new stdClass());
