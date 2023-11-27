<?php

namespace DarkDarin\Serializer;

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
