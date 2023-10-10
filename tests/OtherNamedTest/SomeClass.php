<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\OtherNamedTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class SomeClass
{
    #[JsonMap]
    public int $prop;
}
