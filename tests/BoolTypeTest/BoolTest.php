<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\BoolTypeTest;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class BoolTest extends TestCase
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
                'publicBool' => $faker->boolean(),
                'protectedBool' => $faker->boolean(),
                'privateBool' => $faker->boolean(),
                'publicValueTypeBool' => $faker->boolean(),
                'protectedValueTypeBool' => $faker->boolean(),
                'privateValueTypeBool' => $faker->boolean(),
            ]);

            /** @var object */
            $jsonObject = json_decode($json, false);
            $data[] = [$json, $jsonObject];
        }

        return $data;
    }

    #[DataProvider('jsonProvider')]
    public function testBool(string $json, object $jsonObject): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $publicProperty = $reflection->getProperty('publicBool');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicBool, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedBool');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedBool, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateBool');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateBool, $privateProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('publicValueTypeBool');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicValueTypeBool, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedValueTypeBool');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedValueTypeBool, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateValueTypeBool');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateValueTypeBool, $privateProperty->getValue($myObj));
    }
}
