<?php

namespace DarkDarin\Serializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerFactory;
use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersMapper;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersMapperInterface;
use Illuminate\Support\ServiceProvider;

/**
 * @psalm-api
 */
class SerializerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiSerializerInterface::class, (new ApiSerializerFactory())(...));
        $this->app->singleton(MethodParametersMapperInterface::class, MethodParametersMapper::class);
    }
}
