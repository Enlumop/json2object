<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

use Enlumop\JsonMapper\Attribute\ParseMap;

class InnerTestDto
{
    #[ParseMap(type: 'int')]
    public int $money;
}
