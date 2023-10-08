<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\IntTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    #[JsonMap(type: 'int')]
    public int $publicInt;

    #[JsonMap]
    public int $publicValueTypeInt;

    #[JsonMap(type: 'int')]
    protected int $protectedInt;

    #[JsonMap]
    protected int $protectedValueTypeInt;

    #[JsonMap(type: 'int')]
    private int $privateInt;

    #[JsonMap]
    private int $privateValueTypeInt;

    public function getProtectedInt(): int
    {
        return $this->protectedInt;
    }

    public function getPrivateInt(): int
    {
        return $this->privateInt;
    }

    public function getProtectedValueTypeInt(): int
    {
        return $this->protectedValueTypeInt;
    }

    public function getPrivateValueTypeInt(): int
    {
        return $this->privateValueTypeInt;
    }
}
