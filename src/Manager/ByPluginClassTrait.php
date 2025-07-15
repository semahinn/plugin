<?php

namespace Snr\Plugin\Manager;

trait ByPluginClassTrait {

  /**
   * {@inheritdoc}
   */
  public function getPluginClass(string $type) {
    $plugin_definition = $this->getDefinition($type, FALSE);
    return $plugin_definition['class'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitionByPluginClass(string $class) {
    $plugin_definitions = $this->getDefinitions();
    foreach ($plugin_definitions as $definition) {
      if ($definition['class'] == $class)
        return $definition;
    }
    return null;
  }
}
