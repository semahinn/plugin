<?php

namespace Snr\Annotation\Discovery;

use Snr\Plugin\Discovery\DiscoveryInterface;
use Snr\Plugin\Discovery\DiscoveryTrait;

/**
 * Здесь ОПРЕДЕЛЕНИЕ ПЛАГИНА описывается
 * с помощью прикрепляемого к классу атрибута
 */
class AttributedClassDiscovery implements DiscoveryInterface {
  
  use DiscoveryTrait;
  
  /**
   * {@inheritdoc}
   */
  public function getDefinitions(): array {
    // TODO: Implement getDefinitions() method.
  }
  
}