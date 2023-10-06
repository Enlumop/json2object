<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

use Enlumop\JsonMapper\Attribute\ParseMap;

class TestDto
{
    #[ParseMap(type: 'string')]
    public string $name;
    #[ParseMap(type: 'int')]
    public int $age;

    #[ParseMap(type: InnerTestDto::class)]
    public InnerTestDto $inner;

    /**
     * @var array<string>
     */
    #[ParseMap(type: 'array<string>')]
    public array $stringArray;

    /**
     * @var array<int>
     */
    #[ParseMap(type: 'array<int>')]
    public array $intArray;

    #[ParseMap(jsonPropertyName: 'shortlyUserName')]
    public string $shortName;

    #[ParseMap(type: 'bool')]
    public bool $fromOtherType;

    /**
     * @var array<InnerTestDto>
     */
    #[ParseMap(type: 'array<Enlumop\JsonMapper\Test\InnerTestDto>')]
    public array $objectsArray;
}
