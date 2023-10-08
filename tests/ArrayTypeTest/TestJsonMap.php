<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\ArrayTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    /**
     * @var array<string>
     */
    #[JsonMap('array<string>')]
    public array $stringArray;

    /**
     * @var array<int>
     */
    #[JsonMap('array<int>')]
    public array $intArray;

    /**
     * @var array<bool>
     */
    #[JsonMap('array<bool>')]
    public array $boolArray;

    /**
     * @var array<ObjectInArray>
     */
    #[JsonMap('array<'.ObjectInArray::class.'>')]
    public array $objectArray;

    /**
     * @var array<mixed>
     */
    #[JsonMap('array<mixed>')]
    public array $mixedArray;
}
