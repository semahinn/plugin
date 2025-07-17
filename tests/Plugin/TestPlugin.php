<?php

namespace Snr\Plugin\Tests\Plugin;

use Snr\Plugin\Tests\TestKernel;

/**
 * @Plugin(
 *   id = "test_plugin",
 *   label = "Test Plugin",
 * )
 */
final class TestPlugin implements TestPluginInterface {
  
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
  public function getPluginManager() {
    return TestKernel::getContainer()->get('plugin.manager.default');
  }

}