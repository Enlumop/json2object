<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\OtherNamedTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    #[JsonMap(jsonPropertyName: 'otherName1')]
    public int $number;
    #[JsonMap(jsonPropertyName: 'otherName2')]
    public string $text;
    #[JsonMap(jsonPropertyName: 'otherName3')]
    public bool $isItTrue;
    #[JsonMap(jsonPropertyName: 'otherName4')]
    public float $floatingPoint;
    #[JsonMap(SomeClass::class, 'otherName5')]
    public SomeClass $someObject;

    /**
     * @var array<int, int>
     */
    #[JsonMap('array<int>', 'otherName6')]
    public array $someArray;
}
