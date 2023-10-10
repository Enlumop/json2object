<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\ArrayTypeTest;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class ArraysTest extends TestCase
{
    /**
     * @return array<int, array<int, mixed>>
     */
    public static function jsonProvider(): array
    {
        $faker = Factory::create();

        /** @phpstan-ignore-next-line */
        function generateObject(\Faker\Generator $faker): ObjectInArray
        {
            $obj = new ObjectInArray();
            $obj->prop = $faker->randomNumber();

            return $obj;
        }

        $data = [];
        for ($i = 0; $i < 5; ++$i) {
            $jsonArray = [
                'stringArray' => $faker->sentences(5),
                'intArray' => [
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                ],
                'boolArray' => [
                    $faker->boolean(),
                    $faker->boolean(),
                    $faker->boolean(),
                    $faker->boolean(),
                    $faker->boolean(),
                ],
                'objectArray' => [
                    // @phpstan-ignore-next-line
                    generateObject($faker),
                    // @phpstan-ignore-next-line
                    generateObject($faker),
                    // @phpstan-ignore-next-line
                    generateObject($faker),
                    // @phpstan-ignore-next-line
                    generateObject($faker),
                    // @phpstan-ignore-next-line
                    generateObject($faker),
                ],
                'mixedArray' => [
                    $faker->word(),
                    $faker->randomNumber(),
                    $faker->boolean(),
                ],
            ];

            /** @var string */
            $json = json_encode($jsonArray);

            $data[] = [$json, $jsonArray];
        }

        return $data;
    }

    /** @phpstan-ignore-next-line */
    #[DataProvider('jsonProvider')]
    /**
     * @param array<string, mixed> $jsonArray
     */
    public function testArrays(string $json, array $jsonArray): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $reflection = new \ReflectionClass($myObj);
        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            if ('objectArray' !== $propertyName) {
                $property->setAccessible(true);
                self::assertSame($jsonArray[$propertyName], $property->getValue($myObj));
            }
        }

        foreach ($myObj->objectArray as $key => $obj) {
            self::assertIsObject($obj);
            self::assertSame($jsonArray['objectArray'][$key]->prop, $obj->prop);
        }
    }
}
