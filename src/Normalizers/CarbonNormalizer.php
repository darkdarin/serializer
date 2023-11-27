<?php

namespace DarkDarin\Serializer\Normalizers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTimeInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @psalm-api
 */
class CarbonNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public const FORMAT_KEY = 'carbon_format';
    public const TIMEZONE_KEY = 'carbon_timezone';
    public const INTERVAL_FORMAT_KEY = 'carbon_interval_format';
    public const INTERVAL_LOCALE_KEY = 'carbon_interval_locale';

    private array $defaultContext = [
        self::FORMAT_KEY => DateTimeInterface::RFC3339,
        self::TIMEZONE_KEY => null,
        self::INTERVAL_FORMAT_KEY => '%rP%yY%mM%dDT%hH%iM%sS',
        self::INTERVAL_LOCALE_KEY => null,
    ];

    public function __construct(array $defaultContext = [])
    {
        $this->defaultContext = array_merge($this->defaultContext, $defaultContext);
    }

    /**
     * @psalm-suppress PossiblyUnusedParam
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Carbon::class => true,
            CarbonInterval::class => true,
        ];
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (!$object instanceof Carbon && !$object instanceof CarbonInterval) {
            throw new InvalidArgumentException(
                sprintf('The object must be an instance of "%s" or "%s.', Carbon::class, CarbonInterval::class)
            );
        }

        if ($object instanceof Carbon) {
            return $object->format($context[self::FORMAT_KEY] ?? $this->defaultContext[self::FORMAT_KEY]);
        } else {
            return $object->format(
                $context[self::INTERVAL_FORMAT_KEY] ?? $this->defaultContext[self::INTERVAL_FORMAT_KEY]
            );
        }
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Carbon || $data instanceof CarbonInterval;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (!is_string($data) && !is_int($data)) {
            throw new InvalidArgumentException(
                sprintf('Data expected to be a string, "%s" given.', get_debug_type($data))
            );
        }

        if ($type === Carbon::class) {
            return Carbon::parse($data);
        } elseif ($type === CarbonInterval::class) {
            return CarbonInterval::parseFromLocale(
                $data,
                $context[self::INTERVAL_LOCALE_KEY] ?? $this->defaultContext[self::INTERVAL_LOCALE_KEY]
            );
        }

        throw new InvalidArgumentException(
            sprintf('The property must have type of "%s" or "%s.', Carbon::class, CarbonInterval::class)
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return (is_string($data) || is_int($data)) && ($type === Carbon::class || $type === CarbonInterval::class);
    }
}

