<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper;

/**
 * @template T of object
 *
 * @param class-string<T> $targetClass
 *
 * @return T
 */
function json2Obj(string $targetClass, string|object $json)
{
    $conventer = new JsonConventer($targetClass, $json);

    return $conventer->toObj();
}
