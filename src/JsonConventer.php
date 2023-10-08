<?php

declare(strict_types=1);

namespace Enlumop\JsonMapper;

use Enlumop\JsonMapper\Attribute\JsonMap;

/**
 * @template T of object
 */
class JsonConventer
{
    /**
     * @var T
     */
    private $templateObject;

    private \ReflectionClass $refClass;

    /**
     * Undocumented function.
     *
     * @param class-string<T> $targetClass
     */
    public function __construct(
        private string $targetClass,
        private string|object $json
    ) {}

    /**
     * @return T
     */
    public function toObj()
    {
        JsonMapReflectionsValidator::checkClassName($this->targetClass);

        $this->refClass = new \ReflectionClass($this->targetClass);
        $this->templateObject = $this->refClass->newInstance();
        $jsonObject = $this->getJsonObject();

        /**
         * @var \ReflectionProperty $property
         */
        foreach ($this->refClass->getProperties() as $property) {
            $attributes = $property->getAttributes(JsonMap::class);

            if (empty($attributes)) {
                return $this->templateObject;
            }

            $attr = $attributes[0]->newInstance();

            $type = $this->determinateType($attr, $property);
            $jsonProperty = $attr->jsonPropertyName ?? $property->getName();

            $this->setTemplateProperty($type, $property, $jsonObject, $jsonProperty);
        }

        return $this->templateObject;
    }

    private function determinateType(JsonMap $attr, \ReflectionProperty $property): string
    {
        $refType = $property->getType();
        $propertyType = null;
        if ($refType instanceof \ReflectionNamedType) {
            $propertyType = $refType->getName();
        }

        return $attr->type ?? $propertyType ?? 'mixed';
    }

    private function getJsonObject(): object
    {
        $json = \is_string($this->json) ? json_decode($this->json, false) : $this->json;
        if (!\is_object($json)) {
            throw new \InvalidArgumentException('JSON must be an object');
        }

        return $json;
    }

    private function setTemplateProperty(
        string $type,
        \ReflectionProperty $property,
        object $jsonObject,
        string $jsonProperty
    ): void {
        if (class_exists($type)) {
            $relatedObject = json2Obj($type, $jsonObject->{$jsonProperty});
            $this->setRegularValue($relatedObject, 'mixed', $property);
        } elseif (str_starts_with($type, 'array')) {
            $typeArray = $this->getArrayType($type);
            $this->mapArray($jsonObject, $jsonProperty, $typeArray, $property);
        } else {
            $this->setRegularValue($jsonObject->{$jsonProperty}, $type, $property);
        }
    }

    private function mapArray(
        object $jsonObject,
        string $jsonProperty,
        string $typeArray,
        \ReflectionProperty $property
    ): void {
        $newArr = [];
        foreach ($jsonObject->{$jsonProperty} as $jsonArrayValue) {
            if (class_exists($typeArray)) {
                $newArr[] = json2Obj($typeArray, $jsonArrayValue);
            } else {
                $newArr[] = $this->getRegularValue($jsonArrayValue, $typeArray);
            }
        }

        $this->setRegularValue($newArr, 'mixed', $property);
    }

    private function getArrayType(string $arrayWithType): string
    {
        $typeArray = explode('<', $arrayWithType);
        $type = $typeArray[1] ?? 'mixed';

        return str_replace('>', '', $type);
    }

    private function setRegularValue(mixed $value, string $type, \ReflectionProperty $property): void
    {
        $value = $this->getRegularValue($value, $type);

        $property->setAccessible(true);
        $property->setValue($this->templateObject, $value);
    }

    private function getRegularValue(mixed $value, string $type): mixed
    {
        if ('mixed' !== $type) {
            settype($value, $type);
        }

        return $value;
    }
}
