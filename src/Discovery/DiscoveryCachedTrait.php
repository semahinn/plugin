<?php

namespace Snr\Plugin\Discovery;

trait DiscoveryCachedTrait {
  
  use DiscoveryTrait;
  
  /**
   * Найденные определения плагинов
   *
   * @var array
   */
  protected $definitions;
  
  /**
   * {@inheritdoc}
   */
  public function getDefinition(string $plugin_id, bool $exception_on_invalid = TRUE): ?array {
    if (!isset($this->definitions)) {
      $this->getDefinitions();
    }
    return $this->doGetDefinition($this->definitions, $plugin_id, $exception_on_invalid);
  }
  
}
