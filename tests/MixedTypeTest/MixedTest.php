<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\MixedTypeTest;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class MixedTest extends TestCase
{
    /**
     * @return array<int, array<int, mixed>>
     */
    public static function jsonProvider(): array
    {
        $faker = Factory::create();

        function elements(\Faker\Generator $faker): array
        {
            return [
                $faker->randomNumber(),
                $faker->word(),
                $faker->boolean(),
                $faker->randomFloat(),
            ];
        }

        $data = [];
        for ($i = 0; $i < 5; ++$i) {
            /** @var string */
            $json = json_encode([
                'mixed1' => $faker->randomElement(elements($faker)),
                'mixed2' => $faker->randomElement(elements($faker)),
                'mixed3' => $faker->randomElement(elements($faker)),
                'mixed4' => $faker->randomElement(elements($faker)),
                'mixed5' => $faker->randomElement(elements($faker)),
            ]);

            /** @var object */
            $jsonObject = json_decode($json, false);
            $data[] = [$json, $jsonObject];
        }

        return $data;
    }

    #[DataProvider('jsonProvider')]
    public function testMixed(string $json, object $jsonObject): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $publicProperty = $reflection->getProperty('mixed1');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->mixed1, $publicProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('mixed2');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->mixed2, $publicProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('mixed3');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->mixed3, $publicProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('mixed4');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->mixed4, $publicProperty->getValue($myObj));

        $publicProperty = $reflection->getProperty('mixed5');
        $publicProperty->setAccessible(true);
        self::assertSame($jsonObject->mixed5, $publicProperty->getValue($myObj));
    }
}
