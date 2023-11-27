<?php

namespace DarkDarin\Serializer;

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
