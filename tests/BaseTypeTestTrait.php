<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test;

use PHPUnit\Framework\Attributes\DataProvider;

use function Enlumop\JsonMapper\json2Obj;

trait BaseTypeTestTrait
{
    #[DataProvider('jsonProvider')]
    public function testType(string $json, object $jsonObject): void
    {
        /** @phpstan-ignore-next-line */
        $myObj = json2Obj($this->testingClass, $json);

        $reflection = new \ReflectionClass($myObj);
        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $property->setAccessible(true);
            self::assertSame($jsonObject->{$propertyName}, $property->getValue($myObj));
        }
    }
}
