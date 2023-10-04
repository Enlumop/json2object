<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper;

final class JsonMapReflectionsValidator
{
    private function __construct() {}

    public static function checkProperty(\ReflectionProperty $property): void
    {
        $propertyName = $property->getName();
        $class = $property->getDeclaringClass()->getNamespaceName();

        if ($property->isReadOnly()) {
            throw new \InvalidArgumentException("The property {$class}\${$propertyName} is readonly and cannot be set.");
        }

        if (!$property->isPublic()) {
            throw new \InvalidArgumentException("The property {$class}\${$propertyName} is not public. Must be public");
        }
    }

    /**
     * @param class-string $class
     */
    public static function checkClassName(string $class): void
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Class name must be a string type');
        }
    }
}
