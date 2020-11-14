# typed-arrays
A library of simple classes using PHP's scalar type declarations to control types within arrays.
The library uses PHPUnit tests, written to thoroughly check that incorrect types can't be added to the arrays.

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
    "coderman17/typed-arrays": "dev-master"
  }
```
Then run `composer update`
## Use
The use of the scalar typed arrays is straightforward - simply create a new instance of the class and rest assured it
will only contain the types you expect.  
You can also use the class as a type declaration in your methods, to be certain that incoming array variables are of
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
Fatal error: Uncaught Exception: PHP will silently cast the key '1' to an integer, violating the key type of string
*/
```
The IntToClassArray and StringToClassArray are abstract, and require a simple class extending them to specify your desired object type,
as in ['IntToBlogPostArray']().  
Just like you can with the scalar type arrays, you can use your extending class as a type declaration in your methods:
```
function show_blog_posts_content(IntToBlogPostArray $intToBlogPostArray): void
```  
You can see a working labelled example of this in ['demo.php']().
 
#### Classes:
- IntToIntArray
- IntToStringArray
- IntToClassArray
- StringToIntArray
- StringToStringArray
- StringToClassArray (coming soon)

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
## Explanation of Design Choices
#### Why not implement ArrayAccess?
Making these classes implement PHP's [ArrayAccess interface](https://www.php.net/manual/en/class.arrayaccess.php) would allow you to do this:
```
$intArray = new IntToIntArray();

$intArray[0] = 1;
```
This looks pretty, but hugely increases the risk of attempting to add the wrong type of key or value to the array.

This is because you can't add scalar type definitions to anything that implements the ArrayAccess interface,
and even with docblocks, your IDE doesn't complain when you do this:
```
$intArray = new IntToIntArray();

//IDE doesn't complain, but PHP throws a TypeError here:
$intArray['string'] = 'string';
```
Of course, we can still protect the key and value types of the actual array, by calling the IntToIntArray `setItem` method from the ArrayAccess `offsetSet` method.

However, implementing ArrayAccess is just not worth the risk when the alternative is so straightforward:
```
$intArray = new IntToIntArray();

//IDE type hints ints:
$intArray->setItem(0, 1);

//IDE reports a type compatibility error:
$intArray->setItem('string', 'string');
```
