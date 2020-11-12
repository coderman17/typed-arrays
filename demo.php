<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use TypedArrays\Demo\BlogPost;                                                      //The class of object we want to put inside a Typed Array
use TypedArrays\Demo\IntToBlogPostArray;                                            //A simple extension of the IntToClassArray abstract class

function show_blog_posts_content (IntToBlogPostArray $intToBlogPostArray): void     //Function declares type of array object required
{
    foreach ($intToBlogPostArray as $blogPost){                                     //The IntToBlogPostArray object can be used like an array in a foreach loop
        echo $blogPost->getContent() . "\n";
    }

    $blogPosts = $intToBlogPostArray->getItems();                                   //Or, the array can be retrieved as a whole via getItems()
}

$intToBlogPostArray = new IntToBlogPostArray();                                     //Make new Array object

                                                                                    //Can add objects of correct class successfully
$intToBlogPostArray->pushItem(new BlogPost('This is a blog post about cats'));      //- via pushItem()
$intToBlogPostArray->setItem(1, new BlogPost('This is a blog post about food'));    //- via setItem() to specify the key too

show_blog_posts_content($intToBlogPostArray);                                       //Pass array to function with full type hinting

//$intToBlogPostArray->pushItem(new stdClass());                                    //Exception because of wrong class
