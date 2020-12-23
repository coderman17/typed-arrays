<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class TestHelpers extends TestCase
{
    public const STRING_KEYS_PHP_WILL_NOT_CAST_AS_INT = [
        '0.1',              //float from 0
        '2.2',              //float from >=1
        'true',             //bool
        'false',            //bool
        'null',             //null
        'a',                //string
        '2a',               //int-string
        'a3',               //string-int
        '04',               //int, leading zero
        '0x05',             //hexadecimal
        '0b100',            //binary
        '-0',               //neg 0
        '-0.5',             //neg float
        '-5.5'              //neg float
    ];

    public const STRING_KEYS_PHP_WILL_CAST_AS_INT = [
        '0',
        '4',
        '400',
        '-4',
        '-400'
    ];

    /**
     * Unlike PHPUnit's expectException, this allows for testing of multiple exceptions thrown from a loop
     * (expectException stops processing after the first exception is thrown)
     *
     * @param callable $method
     * @param array<int, mixed> $args
     * @return null|\Exception
     */
    public static function getExceptionOnMethod(callable $method, array $args): ?\Exception
    {
        try {
            $method(...$args);
        } catch (\Exception $e){
            return $e;
        }

        return null;
    }

    /**
     * This test checks an exception is thrown rather than letting PHP quietly convert string keys to integers
     *
     * @param callable $method
     * @param mixed $acceptableArrayValue
     * @param TestCase $callingTest
     */
    public static function checkForSilentKeyTypeCastingException(callable $method, $acceptableArrayValue, TestCase $callingTest): void
    {
        $keyList = TestHelpers::STRING_KEYS_PHP_WILL_CAST_AS_INT;

        foreach ($keyList as $key){
            $e = TestHelpers::getExceptionOnMethod($method, [$key, $acceptableArrayValue]);

            if (!$e instanceOf \InvalidArgumentException){
                $callingTest::fail('Expected an InvalidArgumentException but one was not thrown');
            }

            $callingTest::assertSame(
                'PHP was about to silently cast',
                substr($e->getMessage(), 0, 30)
            );
        }
    }

    public static function newEmptyClassObject(): object
    {
        return new class {};
    }

    /**
     * @param class-string $className
     * @param string $methodName
     * @param string $targetParameterName
     * @param TestCase $callingTest
     * @return string
     */
    public static function getParameterType(string $className, string $methodName, string $targetParameterName, TestCase $callingTest): string
    {
        try {
            $method = new \ReflectionMethod($className, $methodName);

            $params = $method->getParameters();

            foreach ($params as $param){
                if($param->getName() === $targetParameterName){
                    $type = $param->getType();

                    if($type === null){
                        throw new \Exception("The '" . $targetParameterName . "' parameter doesn't specify a type in '" . $methodName . "' method in '" . $className . "' class");
                    }

                    if(!$type instanceof \ReflectionNamedType){
                        throw new \Exception("The '" . $targetParameterName . "' parameter's type is not recognised");
                    }

                    return $type->getName();
                }
            }

            throw new \Exception("Couldn't find '" . $targetParameterName . "' parameter in '" . $methodName . "' method in '" . $className . "' class");

        } catch (\Exception $e) {
            $callingTest::fail($e->getMessage());
        }
    }
}
