<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\ArrayTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class ObjectInArray
{
    #[JsonMap]
    public int $prop;
}
