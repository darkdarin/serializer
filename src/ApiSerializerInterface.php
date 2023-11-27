<?php

namespace DarkDarin\Serializer;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

interface ApiSerializerInterface extends SerializerInterface, NormalizerInterface, DenormalizerInterface,
    EncoderInterface, DecoderInterface {}
