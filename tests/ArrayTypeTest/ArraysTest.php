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

        function generateStdClass(\Faker\Generator $faker): ObjectInArray
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
                    generateStdClass($faker),
                    generateStdClass($faker),
                    generateStdClass($faker),
                    generateStdClass($faker),
                    generateStdClass($faker),
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

    #[DataProvider('jsonProvider')]
    public function testArrays(string $json, array $jsonArray): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        $property = $reflection->getProperty('stringArray');
        $property->setAccessible(true);
        self::assertSame($jsonArray['stringArray'], $property->getValue($myObj));

        $property = $reflection->getProperty('intArray');
        $property->setAccessible(true);
        self::assertSame($jsonArray['intArray'], $property->getValue($myObj));

        $property = $reflection->getProperty('boolArray');
        $property->setAccessible(true);
        self::assertSame($jsonArray['boolArray'], $property->getValue($myObj));

        foreach ($myObj->objectArray as $key => $obj) {
            self::assertIsObject($obj);
            self::assertSame($jsonArray['objectArray'][$key]->prop, $obj->prop);
        }

        $property = $reflection->getProperty('mixedArray');
        $property->setAccessible(true);
        self::assertSame($jsonArray['mixedArray'], $property->getValue($myObj));
    }
}
