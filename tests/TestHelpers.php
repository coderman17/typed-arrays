<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class TestHelpers extends TestCase
{
    public static function getParameterType(string $className, string $methodName, string $parameterName): string
    {
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
    }
}
