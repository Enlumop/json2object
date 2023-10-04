<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper;

use Enlumop\JsonMapper\Attribute\ParseMap;

/**
 * @template T of object
 *
 * @param class-string<T> $class
 *
 * @return T
 */
function createObjectByJson(string $class, string|object $json)
{
    JsonMapReflectionsValidator::checkClassName($class);

    $reflectionClass = new \ReflectionClass($class);
    $templateObject = new $class();
    $jsonObject = \is_string($json) ? json_decode($json, false) : $json;

    foreach ($reflectionClass->getProperties() as $property) {
        $attributes = $property->getAttributes(ParseMap::class);
        if (!empty($attributes)) {
            JsonMapReflectionsValidator::checkProperty($property);
            $propertyName = $property->getName();

            $attr = $attributes[0]->newInstance();
            $type = $attr->type ?? 'string';
            $jsonProperty = $attr->jsonPropertyName ?? $property->getName();
            if (class_exists($type)) {
                $templateObject->{$propertyName} = createObjectByJson($type, $jsonObject->{$jsonProperty});
            } elseif (str_starts_with($type, 'array')) {
                $typeArray = explode('<', $type);
                $typeArray = str_replace('>', '', $typeArray[1]);
                $templateObject->{$propertyName} = [];
                foreach ($jsonObject->{$jsonProperty} as $jsonArrayValue) {
                    if (class_exists($typeArray)) {
                        $templateObject->{$propertyName}[] = createObjectByJson($typeArray, $jsonArrayValue);
                    } else {
                        addRegularValue($jsonArrayValue, $typeArray, $templateObject, $propertyName);
                    }
                }
            } else {
                setRegularValue($jsonObject->{$jsonProperty}, $type, $templateObject, $propertyName);
            }
        }
    }

    return $templateObject;
}

function setRegularValue(mixed $value, string $type, object &$template, string $templateProperty): void
{
    settype($value, $type);
    $template->{$templateProperty} = $value;
}

function addRegularValue(mixed $value, null|string $type = null, object &$template, string $templateProperty): void
{
    settype($value, $type);
    $template->{$templateProperty}[] = $value;
}
