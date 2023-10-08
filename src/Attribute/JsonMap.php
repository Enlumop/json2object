<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class JsonMap
{
    /**
     * @param null|class-string|string $type             Set type or class. Default it is string. If it is an array, tell me what type. Use a generic type tag, e.g. array<string> or array<class-name>
     * @param null|string              $jsonPropertyName Set if the name is different from the class property name
     */
    public function __construct(
        public null|string $type = null,
        public null|string $jsonPropertyName = null,
    ) {}
}
