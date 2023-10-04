<?php

declare(strict_types=1);

namespace Enlumop\JsonParser;

use Enlumop\JsonParser\Attribute\ParseMap;

// /**
//  * @template T
//  *
//  * @param class-string<T> $class
//  *
//  * @return T
//  */
function jsonMap(string $class, string $json): void
{
    $reflectionClass = new \ReflectionClass($class);
    $templateObject = new $class();
    $jsonObject = json_decode($json, false);

    foreach ($reflectionClass->getProperties() as $property) {
        $attributes = $property->getAttributes(ParseMap::class);
        if (!empty($attributes)) {
            $propertyName = $property->getName();

            $attr = $attributes[0]->newInstance();
            $type = $attr->type ?? 'string';
            $jsonProperty = $attr->jsonPropertyName ?? $property->getName();

            echo "{$class}::\${$propertyName} => type {$type} | map with {$jsonProperty}\n";
        }
    }
}
