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

        $reflectionClass = new \ReflectionClass($this->targetClass);
        $this->templateObject = $reflectionClass->newInstance();
        $jsonObject = $this->getJsonObject();

        /**
         * @var \ReflectionProperty $property
         */
        foreach ($reflectionClass->getProperties() as $property) {
            $attributes = $property->getAttributes(JsonMap::class);

            if (empty($attributes)) {
                return $this->templateObject;
            }
            JsonMapReflectionsValidator::checkProperty($property);
            $propertyName = $property->getName();

            $attr = $attributes[0]->newInstance();

            $type = $this->determinateType($attr, $property);
            $jsonProperty = $attr->jsonPropertyName ?? $property->getName();

            $this->setTemplateProperty($type, $propertyName, $jsonObject, $jsonProperty);
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

    private function setTemplateProperty(string $type, string $propertyName, object $jsonObject, string $jsonProperty): void
    {
        if (class_exists($type)) {
            $this->templateObject->{$propertyName} = json2Obj($type, $jsonObject->{$jsonProperty});
        } elseif (str_starts_with($type, 'array')) {
            $typeArray = $this->getArrayType($type);
            $this->templateObject->{$propertyName} = [];
            $this->mapArray($jsonObject, $jsonProperty, $typeArray, $propertyName);
        } else {
            $this->setRegularValue($jsonObject->{$jsonProperty}, $type, $propertyName);
        }
    }

    private function mapArray(object $jsonObject, string $jsonProperty, string $typeArray, string $templateProperty): void
    {
        foreach ($jsonObject->{$jsonProperty} as $jsonArrayValue) {
            if (class_exists($typeArray)) {
                $this->templateObject->{$templateProperty}[] = json2Obj($typeArray, $jsonArrayValue);
            } else {
                $this->addRegularValue($jsonArrayValue, $typeArray, $templateProperty);
            }
        }
    }

    private function getArrayType(string $arrayWithType): string
    {
        $typeArray = explode('<', $arrayWithType);
        $type = $typeArray[1] ?? 'mixed';

        return str_replace('>', '', $type);
    }

    private function setRegularValue(mixed $value, string $type, string $templateProperty): void
    {
        if ('mixed' !== $type) {
            settype($value, $type);
        }
        $this->templateObject->{$templateProperty} = $value;
    }

    private function addRegularValue(mixed $value, string $type, string $templateProperty): void
    {
        if ('mixed' !== $type) {
            settype($value, $type);
        }
        $this->templateObject->{$templateProperty}[] = $value;
    }
}
