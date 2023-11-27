<?php

namespace DarkDarin\Serializer\MethodParametersSerializer;

interface MethodParametersSerializerInterface
{
    public function serialize(
        string $method,
        array $arguments,
        string $format,
        array $context = []
    ): string;

    public function normalize(
        string $method,
        array $arguments,
        string $format = null,
        array $context = []
    ): array|\ArrayObject|bool|float|int|null|string;
}
