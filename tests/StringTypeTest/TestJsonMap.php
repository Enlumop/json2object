<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\StringTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    #[JsonMap(type: 'string')]
    public string $publicString;

    #[JsonMap]
    public string $publicValueTypeString;

    #[JsonMap(type: 'string')]
    protected string $protectedString;

    #[JsonMap]
    protected string $protectedValueTypeString;

    #[JsonMap(type: 'string')]
    private string $privateString;

    #[JsonMap]
    private string $privateValueTypeString;

    public function getProtectedString(): string
    {
        return $this->protectedString;
    }

    public function getPrivateString(): string
    {
        return $this->privateString;
    }

    public function getProtectedValueTypeString(): string
    {
        return $this->protectedValueTypeString;
    }

    public function getPrivateValueTypeString(): string
    {
        return $this->privateValueTypeString;
    }
}
