<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\StringTypeTest;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class StringTest extends TestCase
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
                'publicString' => $faker->randomAscii(),
                'protectedString' => $faker->randomAscii(),
                'privateString' => $faker->randomAscii(),
                'publicValueTypeString' => $faker->randomAscii(),
                'protectedValueTypeString' => $faker->randomAscii(),
                'privateValueTypeString' => $faker->randomAscii(),
            ]);

            /** @var object */
            $jsonObject = json_decode($json, false);
            $data[] = [$json, $jsonObject];
        }

        return $data;
    }

    #[DataProvider('jsonProvider')]
    public function testString(string $json, object $jsonObject): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $publicProperty = $reflection->getProperty('publicString');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicString, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedString');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedString, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateString');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateString, $privateProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('publicValueTypeString');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->publicValueTypeString, $publicProperty->getValue($myObj));

        $protectedProperty = $reflection->getProperty('protectedValueTypeString');
        $protectedProperty->setAccessible(true);
        self::assertSame($jsonObject->protectedValueTypeString, $protectedProperty->getValue($myObj));

        $privateProperty = $reflection->getProperty('privateValueTypeString');
        $privateProperty->setAccessible(true);
        self::assertSame($jsonObject->privateValueTypeString, $privateProperty->getValue($myObj));
    }
}
