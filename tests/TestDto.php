<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestDto
{
    #[JsonMap(type: 'string')]
    public string $name;
    #[JsonMap(type: 'int')]
    public int $age;

    #[JsonMap(type: InnerTestDto::class)]
    public InnerTestDto $inner;

    /**
     * @var array<string>
     */
    #[JsonMap(type: 'array<string>')]
    public array $stringArray;

    /**
     * @var array<int>
     */
    #[JsonMap(type: 'array<int>')]
    public array $intArray;

    #[JsonMap(jsonPropertyName: 'shortlyUserName')]
    public string $shortName;

    #[JsonMap]
    public bool $fromOtherType;

    #[JsonMap]
    public mixed $mixedValue;

    /**
     * @var array<InnerTestDto>
     */
    #[JsonMap(type: 'array<'.InnerTestDto::class.'>')]
    public array $objectsArray;
}
