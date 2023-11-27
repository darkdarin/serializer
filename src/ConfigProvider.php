<?php

namespace DarkDarin\Serializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerFactory;
use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersSerializer;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersSerializerInterface;

/**
 * @psalm-api
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ApiSerializerInterface::class => ApiSerializerFactory::class,
                MethodParametersSerializerInterface::class => MethodParametersSerializer::class,
            ],
        ];
    }
}
