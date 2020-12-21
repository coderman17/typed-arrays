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
     * @param array $args
     * @return null|\Exception
     */
    public static function expectExceptionOnMethod(callable $method, array $args): ?\Exception
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

        for ($i = 0; $i < count($keyList); $i++){
            $e = TestHelpers::expectExceptionOnMethod($method, [$keyList[$i], $acceptableArrayValue]);

            if ($e === null){
                $callingTest::fail('Expected an exception but one was not thrown');
            }

            $callingTest::assertSame(
                'PHP was about to silently cast the key',
                substr($e->getMessage(), 0, 38)
            );
        }
    }

    /**
     * @param class-string $className
     * @param string $methodName
     * @param string $parameterName
     * @param TestCase $callingTest
     * @return string
     */
    public static function getParameterType(string $className, string $methodName, string $parameterName, TestCase $callingTest): string
    {
        try {
            $setItemMethod = new \ReflectionMethod($className, $methodName);

            $params = $setItemMethod->getParameters();

            foreach ($params as $param){
                if($param->getName() === $parameterName){
                    if($param->getType() === null){
                        throw new \Exception("The '" . $parameterName . "' parameter doesn't specify a type in '" . $methodName . "' method in '" . $className . "' class");
                    }

                    $type = $param->getType();

                    if($type instanceof \ReflectionNamedType){
                        return $type->getName();
                    }

                    throw new \Exception("The '" . $parameterName . "' parameter's type is not recognised");
                }
            }

            throw new \Exception("Couldn't find '" . $parameterName . "' parameter in '" . $methodName . "' method in '" . $className . "' class");

        } catch (\Exception $e) {
            $callingTest::fail($e->getMessage());
        }
    }
}
