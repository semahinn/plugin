<?php

namespace Snr\Plugin\Plugin;

/**
 * @Plugin(
 *   id = "example_plugin",
 *   label = "Example Plugin",
 * )
 */
class ExamplePlugin implements ExamplePluginInterface {
  
  /**
   * @var string
   */
  protected $phrase;
  
  public function __construct(array $configuration, string $plugin_id, array $plugin_definition) {
    if (!empty($configuration['phrase']) && is_string($configuration['phrase'])) {
      $this->phrase = $configuration['phrase'];
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public static function getPluginManager() {
    // TODO: Implement getPluginManager() method.
  }
}