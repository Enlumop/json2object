<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

use Enlumop\JsonMapper\Attribute\JsonMap;

class InnerTestDto
{
    #[JsonMap(type: 'int')]
    public int $money;
}
