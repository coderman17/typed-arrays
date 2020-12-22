[![Build Status](https://travis-ci.com/coderman17/typed-arrays.svg?branch=master)](https://travis-ci.com/coderman17/typed-arrays)
[![codecov.io](https://codecov.io/gh/coderman17/typed-arrays/branch/Master/graphs/badge.svg)](https://app.codecov.io/gh/coderman17/typed-arrays/branch/Master)
# typed-arrays
A PHP library of simple classes to control types within arrays. The project uses a *Key*To*Value*Array naming format (e.g. IntToStringArray) to let you specify both the key and value type.  
The library uses PHPUnit tests, written to thoroughly check incorrect types can't be added to the arrays.

#### Classes:
- IntToIntArray
- IntToStringArray
- IntToClassArray
- StringToIntArray
- StringToStringArray
- StringToClassArray

## Pre-requisites
You must have [composer](https://getcomposer.org/download/) and php >= 7.4 installed.
## Installation
Add this to your composer.json file:
```
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/coderman17/typed-arrays"
    }
  ],
  "require": {
    "coderman17/typed-arrays": "0.2.0"
  }
```
Then run `composer update`
## Use
The use of the scalar typed arrays is straightforward - simply create a new instance of the class and rest assured it
will only contain the types you expect.  
You can also use the class as a type declaration in your methods, to be certain incoming arrays are of
the correct key and value type:
```
$intToStringArray = new IntToStringArray();

$intToStringArray->setItem(0, "string 1");

$intToStringArray->pushItem("string 2");

function echo_strings (IntToStringArray $intToStringArray): void
{
    foreach ($intToStringArray as $key => $value){
        echo "For each item in the array (now on item: " . strval($key) . ")\n";
        echo "- The key is always of type integer: " . gettype($key) . "\n";
        echo "- The value is always of type string: " . gettype($value) . "\n\n";
    }
}

echo_strings($intToStringArray);

/*
For each item in the array (now on item: 0)
- The key is always of type integer: integer
- The value is always of type string: string

For each item in the array (now on item: 1)
- The key is always of type integer: integer
- The value is always of type string: string
*/
```
The StringTo... classes will throw an exception if PHP is about to silently convert your string keys into integers,
polluting the array with types you didn't expect:
```
$stringToIntArray->setItem('1', 1);

/*
Fatal error: Uncaught Exception: PHP will silently cast the key '1' to an integer, an exception was thrown instead
*/
```
The IntToClassArray and StringToClassArray classes are abstract, and require a simple class extending them to specify your desired object type,
as in ['IntToBlogPostArray'](https://github.com/coderman17/typed-arrays/blob/master/src/Demo/IntToBlogPostArray.php).  
Just like you can with the scalar typed arrays, you can use your extending class as a type declaration in your methods:
```
function show_blog_posts_content(IntToBlogPostArray $intToBlogPostArray): void
```  
You can see a working labelled example of this and other features here: ['demo.php'](https://github.com/coderman17/typed-arrays/blob/master/demo.php).
 


#### Note:
If you don't add `declare(strict_types = 1);` to the top of the files from which you call TypedArray methods, then PHP
may typecast your variables to match the types declared on those methods.  
For example:
```
//no declare strict_types line

$x = new IntToIntArray();

//no TypeError thrown because the strings are successfully cast to integers
$x->setItem('0', '0');

/*
    $x->getItems() now returns:

    array(1) {
        [0]=>
        int(0)
    }
*/
```
This still guarantees the type of the values stored in the `items` array,
but allowing PHP to magically convert your variable type is rather against the spirit of this project, and I'd recommend you convert types explicitly if necessary.  
The project defends against this when using the `$x[1] = 'string'` format, and will throw a type error
## Explanation of Design Choices
These classes implement the following to allow you to treat the object instances as if they were arrays:
* PHP's [Countable interface](https://www.php.net/manual/en/class.countable) - allowing you to use `count($intToIntArray)`
* PHP's [Iterator interface](https://www.php.net/manual/en/class.iterator.php) - allowing you to use `foreach ($intToIntArray as $int){...}`
* PHP's [ArrayAccess interface](https://www.php.net/manual/en/class.arrayaccess.php) - allowing you to use the syntax `$intToIntArray[0]` with unset(), isset(), and for setting and getting values
