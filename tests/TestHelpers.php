<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use TypedArrays\TypedKeyValueArray;

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
     * @param object $arrayObject
     * @param $key
     * @param $value
     * @param object $callingTest
     */
    public static function expectExceptionOnSetItem(object $arrayObject, $key, $value, object $callingTest)
    {
        try {
            $arrayObject->setItem($key, $value);
        } catch (\Exception $e){
            return;
        }
        $callingTest::fail('Expected an exception but one was not thrown');
    }
    
    public static function getParameterType(string $className, string $methodName, string $parameterName, object $callingTest): string
    {
        try {
            $setItemMethod = new \ReflectionMethod($className, $methodName);

            $params = $setItemMethod->getParameters();

            foreach ($params as $param){
                if($param->getName() === $parameterName){
                    if($param->getType() === null){
                        throw new \Exception("The '" . $parameterName . "' parameter doesn't specify a type in '" . $methodName . "' method in '" . $className . "' class");
                    }

                    return $param->getType()->getName();
                }
            }

            throw new \Exception("Couldn't find '" . $parameterName . "' parameter in '" . $methodName . "' method in '" . $className . "' class");

        } catch (\Exception $e) {
            $callingTest::fail($e->getMessage());

            return '';
        }
    }
}
