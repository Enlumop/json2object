<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\IntTypeTest;

use Enlumop\JsonMapper\Test\BaseTypeTestTrait;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class IntTest extends TestCase
{
    use BaseTypeTestTrait;

    private string $testingClass = TestJsonMap::class;

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
}
