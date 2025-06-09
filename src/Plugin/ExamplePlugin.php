<?php

namespace Snr\Plugin\Plugin;

use Snr\Plugin\Manager\PluginManagerInterface;

/**
 * @Plugin(
 *   id = "example_plugin",
 *   label = "Example Plugin",
 * )
 */
class ExamplePlugin implements ExamplePluginInterface
{
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
  public static function getPluginManager(): PluginManagerInterface {
    // TODO: Implement getPluginManager() method.
  }
}