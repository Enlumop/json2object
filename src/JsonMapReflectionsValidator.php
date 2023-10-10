<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper;

final class JsonMapReflectionsValidator
{
    private function __construct() {}

    /**
     * @param class-string $class
     */
    public static function checkClassName(string $class): void
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Class {$class} is not exists");
        }
    }
}
