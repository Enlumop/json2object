<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\MixedTypeTest;

use Enlumop\JsonMapper\Test\BaseTypeTestTrait;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class MixedTest extends TestCase
{
    use BaseTypeTestTrait;

    private string $testingClass = TestJsonMap::class;

    /**
     * @return array<int, array<int, mixed>>
     */
    public static function jsonProvider(): array
    {
        $faker = Factory::create();

        /** @phpstan-ignore-next-line */
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
                // @phpstan-ignore-next-line
                'mixed1' => $faker->randomElement(elements($faker)),
                // @phpstan-ignore-next-line
                'mixed2' => $faker->randomElement(elements($faker)),
                // @phpstan-ignore-next-line
                'mixed3' => $faker->randomElement(elements($faker)),
                // @phpstan-ignore-next-line
                'mixed4' => $faker->randomElement(elements($faker)),
                // @phpstan-ignore-next-line
                'mixed5' => $faker->randomElement(elements($faker)),
            ]);

            /** @var object */
            $jsonObject = json_decode($json, false);
            $data[] = [$json, $jsonObject];
        }

        return $data;
    }
}
