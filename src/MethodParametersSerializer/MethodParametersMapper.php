<?php

namespace DarkDarin\Serializer\MethodParametersSerializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @psalm-api
 */
readonly class MethodParametersMapper implements MethodParametersMapperInterface
{
    /**
     * @throws \ReflectionException
     */
    public function getNamedArguments(string $method, array $arguments): array
    {
        $methodReflection = new \ReflectionMethod($method);

        $data = [];
        foreach ($methodReflection->getParameters() as $parameter) {
            if (array_key_exists($parameter->getPosition(), $arguments)) {
                $data[$parameter->getName()] = $arguments[$parameter->getPosition()];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $data[$parameter->getName()] = $parameter->getDefaultValue();
            } else {
                throw new MissingArgumentException(
                    sprintf(
                        'Can not get arguments in method [%s]: missing argument [%s]',
                        $method,
                        $parameter->getName()
                    )
                );
            }
        }

        return $data;
    }
}
