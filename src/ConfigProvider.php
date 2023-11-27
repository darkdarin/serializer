<?php

namespace DarkDarin\Serializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerFactory;
use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersMapper;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersMapperInterface;

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
                MethodParametersMapperInterface::class => MethodParametersMapper::class,
            ],
        ];
    }
}
