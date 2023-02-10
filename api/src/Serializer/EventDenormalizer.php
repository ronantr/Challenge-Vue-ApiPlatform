<?php

namespace App\Serializer;

use App\Entity\Event;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class EventDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
  use DenormalizerAwareTrait;

  private $iriConverter;

  public function __construct()
  {
  }

  /**
   * {@inheritdoc}
   */
  public function denormalize($data, $class, $format = null, array $context = [])
  {
    $data["capacity"] = (int) $data["capacity"];

    return $this->denormalizer->denormalize($data, $class, $format, $context + [__CLASS__ => true]);
  }

  /**
   * {@inheritdoc}
   */
  public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
  {
    return \in_array($format, ['multipart'], true) && is_a($type, Event::class, true) && isset($data["capacity"]) && !isset($context[__CLASS__]);
  }
}