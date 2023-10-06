<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

class TestJsonData
{
    public static function create(): string
    {
        $dto = new \stdClass();
        $dto->age = 28;
        $dto->name = 'Lukas';
        $inner = new \stdClass();
        $inner->money = 1234;
        $dto->inner = $inner;
        $dto->stringArray = ['a', 'b', 'c'];
        $dto->intArray = [1, 2, 3, '4'];
        $dto->shortlyUserName = 'Luk';
        $dto->fromOtherType = 1;
        $dto->objectsArray = [
            $inner,
        ];

        $json = json_encode($dto);
        if ($json) {
            return $json;
        }

        return '{}';
    }
}
