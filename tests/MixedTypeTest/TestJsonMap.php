<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\MixedTypeTest;

use Enlumop\JsonMapper\Attribute\JsonMap;

class TestJsonMap
{
    #[JsonMap]
    public mixed $mixed1;
    #[JsonMap]
    public mixed $mixed2;
    #[JsonMap]
    public mixed $mixed3;
    #[JsonMap]
    public mixed $mixed4;
    #[JsonMap]
    public mixed $mixed5;
}
