<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\IntTypeTest;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class IntTest extends TestCase
{
    /**
     * @return array<int, array<int, mixed>>
     */
    public static function jsonProvider(): array
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 5; ++$i) {
            /** @var string */
            $json = json_encode([
                'publicInt' => $faker->randomNumber(),
                'protectedInt' => $faker->randomNumber(),
                'privateInt' => $faker->randomNumber(),
                'publicValueTypeInt' => $faker->randomNumber(),
                'protectedValueTypeInt' => $faker->randomNumber(),
                'privateValueTypeInt' => $faker->randomNumber(),
            ]);

            /** @var object */
            $jsonObject = json_decode($json, false);
            $data[] = [$json, $jsonObject];
        }

        return $data;
    }

    #[DataProvider('jsonProvider')]
    public function testInt(string $json, object $jsonObject): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $publicProperty = $reflection->getProperty('publicInt');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicInt, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedInt');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedInt, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateInt');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateInt, $privateProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('publicValueTypeInt');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicValueTypeInt, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedValueTypeInt');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedValueTypeInt, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateValueTypeInt');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateValueTypeInt, $privateProperty->getValue($myObj));
    }
}
