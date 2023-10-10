<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\StringTypeTest;

use Enlumop\JsonMapper\Test\BaseTypeTestTrait;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class StringTest extends TestCase
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
}
