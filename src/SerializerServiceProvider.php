<?php

namespace DarkDarin\Serializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerFactory;
use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersSerializer;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersSerializerInterface;
use Illuminate\Support\ServiceProvider;

/**
 * @psalm-api
 */
class SerializerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiSerializerInterface::class, (new ApiSerializerFactory())(...));
        $this->app->singleton(MethodParametersSerializerInterface::class, MethodParametersSerializer::class);
    }
}
