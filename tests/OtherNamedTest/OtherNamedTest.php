<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper\Test\OtherNamedTest;

use Enlumop\JsonMapper\Attribute\JsonMap;
use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function Enlumop\JsonMapper\json2Obj;

/**
 * @internal
 *
 * @coversNothing
 */
final class OtherNamedTest extends TestCase
{
    /**
     * @return array<int, array<int, mixed>>
     */
    public static function jsonProvider(): array
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 5; ++$i) {
            $obj = new SomeClass();
            $obj->prop = $faker->randomNumber();

            $jsonArray = [
                'otherName1' => $faker->randomNumber(),
                'otherName2' => $faker->word(),
                'otherName3' => $faker->boolean(),
                'otherName4' => $faker->randomFloat(),
                'otherName5' => $obj,
                'otherName6' => [
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
                    $faker->randomNumber(),
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
    public function testNamed(string $json, array $jsonArray): void
    {
        $myObj = json2Obj(TestJsonMap::class, $json);

        $reflection = new \ReflectionClass($myObj);

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(JsonMap::class);
            $jsonMapAttr = $attributes[0]->newInstance();

            /**
             * @var string $jsonPropertyName
             */
            $jsonPropertyName = $jsonMapAttr->jsonPropertyName;

            if ('otherName5' !== $jsonPropertyName) {
                $property->setAccessible(true);
                self::assertSame($jsonArray[$jsonPropertyName], $property->getValue($myObj));
            }

            self::assertIsObject($myObj);
            self::assertSame($jsonArray['otherName5']->prop, $myObj->someObject->prop);
        }
    }
}
