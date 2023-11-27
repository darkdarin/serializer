<?php

namespace DarkDarin\Serializer\MethodParametersSerializer;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @psalm-api
 */
readonly class MethodParametersSerializer implements MethodParametersSerializerInterface
{
    public function __construct(
        private ApiSerializerInterface $serializer,
    ) {}

    /**
     * @throws \ReflectionException
     */
    public function serialize(
        string $method,
        array $arguments,
        string $format,
        array $context = []
    ): string {
        return $this->serializer->serialize(
            $this->getArguments($method, $arguments),
            $format,
            $context
        );
    }

    /**
     * @throws ExceptionInterface|\ReflectionException
     */
    public function normalize(
        string $method,
        array $arguments,
        string $format = null,
        array $context = []
    ): array|\ArrayObject|bool|float|int|null|string {
        return $this->serializer->normalize(
            $this->getArguments($method, $arguments),
            $format,
            $context
        );
    }

    /**
     * @throws \ReflectionException
     */
    private function getArguments(string $method, array $arguments): object
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

        return (object)$data;
    }
}
