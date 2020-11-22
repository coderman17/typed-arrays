<?php

declare(strict_types = 1);

namespace TypedArrays\Demo;

require 'vendor/autoload.php';


$intToBlogPostArray = new IntToBlogPostArray();                                     //Make new Typed Array object from a simple extension of the IntToClassArray abstract class


$intToBlogPostArray->pushItem(new BlogPost('This is a blog post about cats'));      //You can add objects of the correct class via pushItem()
$intToBlogPostArray->setItem(1, new BlogPost('This is a blog post about food'));    //or via setItem(), to specify the key too


function show_blog_posts_content(IntToBlogPostArray $intToBlogPostArray): void      //Functions can unequivocally declare the type of array object required
{                                                                                   //The array object can be used with assurance that it will only contain int keys and BlogPost objects
    echo "\nThe contents of the BlogPosts in the typed array object are:\n";

    foreach ($intToBlogPostArray as $blogPost) {                                    //The IntToBlogPostArray object can be used like an array in a foreach loop
        echo ' - ' . $blogPost->getContent() . "\n";
    }

    echo "\nTyped array contents can be accessed via var[key] format:\n";

    echo ' - ' . $intToBlogPostArray[0]->getContent() . "\n";                       //The IntToBlogPostArray object's contents can be accessed like an array via var[key]

    echo "\nThe getItems() method on the typed array object gives:\n";

    var_dump($intToBlogPostArray->getItems());                                      //or the array that the object holds can be retrieved as a whole via getItems()

//    $intToBlogPostArray->pushItem(new \stdClass());                                 //Adding objects of incorrect class throws a TypeError
}


show_blog_posts_content($intToBlogPostArray);                                       //Passing variables to the function gives full type hinting of the array object required
