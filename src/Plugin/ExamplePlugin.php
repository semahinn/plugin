<?php

namespace Snr\Plugin\Plugin;

use Snr\Plugin\MockKernel;

/**
 * @Plugin(
 *   id = "example_plugin",
 *   label = "Example Plugin",
 * )
 */
final class ExamplePlugin implements ExamplePluginInterface {
  
  /**
   * @var string
   */
  public $phrase;
  
  public function __construct(array $configuration, string $plugin_id, array $plugin_definition) {
    if (!empty($configuration['phrase']) && is_string($configuration['phrase'])) {
      $this->phrase = $configuration['phrase'];
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public static function getPluginManager() {
    return MockKernel::getContainer()->get('plugin.manager.default');
  }
}