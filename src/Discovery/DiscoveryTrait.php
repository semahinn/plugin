<?php

namespace Snr\Plugin\Discovery;

use Snr\Plugin\Exception\PluginNotFoundException;

trait DiscoveryTrait {

  /**
   * {@inheritdoc}
   */
  abstract public function getDefinitions();

  /**
   * {@inheritdoc}
   */
  public function getDefinition(string $plugin_id, $exception_on_invalid = TRUE) {
    $definitions = $this->getDefinitions();
    return $this->doGetDefinition($definitions, $plugin_id, $exception_on_invalid);
  }
  
  /**
   * Находит определение плагина
   *
   * @param string $plugin_id
   *  Идентификатор плагина
   *
   * @param bool $exception_on_invalid
   *  Если true, то порождает исключение, если
   *  такой плагин не был найден
   *
   * @return array|null
   *  Массив определения плагина или null,
   *  если такой плагин не был найден
   *
   * @throws
   */
  protected function doGetDefinition(array $definitions, string $plugin_id, bool $exception_on_invalid) {
    if (isset($definitions[$plugin_id])) {
      return $definitions[$plugin_id];
    }
    elseif (!$exception_on_invalid) {
      return NULL;
    }

    $valid_ids = implode(', ', array_keys($definitions));
    throw new PluginNotFoundException($plugin_id, sprintf('Плагин "%s" не существует. Перечнь доступных плагинов следующий: %s', $plugin_id, $valid_ids));
  }

  /**
   * {@inheritdoc}
   */
  public function hasDefinition(string $plugin_id) {
    return (bool) $this->getDefinition($plugin_id, FALSE);
  }
}
