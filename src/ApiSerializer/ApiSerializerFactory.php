<?php

namespace DarkDarin\Serializer\ApiSerializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiSerializerFactory
{
    public function __invoke(): ApiSerializerInterface
    {
        return new ApiSerializer($this->getDefaultNormalizers(), [new JsonEncoder()]);
    }

    private function getDefaultNormalizers(): array
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(new AnnotationReader())
        );

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);

        $context = [
            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
        ];

        return [
            new ArrayDenormalizer(),
            new BackedEnumNormalizer(),
            new JsonSerializableNormalizer(),
            new ObjectNormalizer(
                classMetadataFactory:  $classMetadataFactory,
                nameConverter:         $metadataAwareNameConverter,
                propertyTypeExtractor: $extractor,
                defaultContext:        $context,
            ),
        ];
    }
}
