<?php

declare(strict_types=1);

namespace Enlumop\JsonParser\Test;

use Enlumop\JsonParser\Attribute\ParseMap;

class TestDto
{
    #[ParseMap(type: 'string')]
    public string $name;
    #[ParseMap]
    public string $description;

    public int $flag;
}
