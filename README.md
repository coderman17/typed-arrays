# typed-arrays
A library using PHP's scalar type declarations to control types within arrays

## Deeper Explanation
#### Why not implement ArrayAccess?
Making these classes implement PHP's [ArrayAccess interface](https://www.php.net/manual/en/class.arrayaccess.php) would allow you do this:
```
$intArray = new IntToIntArray();

$intArray[0] = 1;
```
This looks pretty, but hugely increases the risk of attempting to add the wrong type of key or value to the array.

This is because you can't add scalar type definitions to anything that implements the ArrayAccess interface,
and even with docblocks, your IDE doesn't complain when you do this:
```
$intArray = new IntToIntArray();

$intArray['string'] = 'string';
```
Implementing ArrayAccess is not worth the risk, particularly when the alternative is so straightforward:
```
$intArray = new IntToIntArray();

//IDE type hints ints:
$intArray->setItem(0, 1);

//IDE reports a type compatibility error:
$intArray->setItem('string', 'string');
```
