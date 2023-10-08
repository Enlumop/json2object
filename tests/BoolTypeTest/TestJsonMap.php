<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\BoolTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    #[JsonMap(type: 'bool')]
    public bool $publicBool;

    #[JsonMap]
    public bool $publicValueTypeBool;

    #[JsonMap(type: 'bool')]
    protected bool $protectedBool;

    #[JsonMap]
    protected bool $protectedValueTypeBool;

    #[JsonMap(type: 'bool')]
    private bool $privateBool;

    #[JsonMap]
    private bool $privateValueTypeBool;

    public function getProtectedBool(): bool
    {
        return $this->protectedBool;
    }

    public function getPrivateBool(): bool
    {
        return $this->privateBool;
    }

    public function getProtectedValueTypeBool(): bool
    {
        return $this->protectedValueTypeBool;
    }

    public function getPrivateValueTypeBool(): bool
    {
        return $this->privateValueTypeBool;
    }
}
