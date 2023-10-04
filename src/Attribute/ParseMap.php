<?php

declare(strict_types=1);

namespace Enlumop\JsonParser\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ParseMap
{
    /**
     * @template T
     *
     * @param null|string                 $jsonPropertyName Set if the name is different from the class property name
     * @param null|class-string<T>|string $type             Set type or class. Default it is string. If it is an array, tell me what type. Use a generic type tag, e.g. array<string> or array<class-name>
     */
    public function __construct(
        public null|string $type = null,
        public null|string $jsonPropertyName = null,
    ) {}
}
