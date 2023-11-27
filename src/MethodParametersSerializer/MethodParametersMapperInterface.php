<?php

namespace DarkDarin\Serializer\MethodParametersSerializer;

interface MethodParametersMapperInterface
{
    /**
     * @param string $method
     * @param list<mixed> $arguments
     * @return array<string, mixed>
     */
    public function getNamedArguments(string $method, array $arguments): array;
}
