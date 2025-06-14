<?php

namespace Snr\Plugin\Factory;

use Snr\Plugin\Exception\PluginException;

/**
 * Предназначено для создания экземпляров определённого плагина,
 * реализующих предназанченный для них интерфейс
 */
interface FactoryInterface {

  /**
   * Создаёт экземпляры определённого плагина
   *
   * @param string $plugin_id
   *  Идентификатор плагина
   *
   * @param array $configuration
   *  Инициализационные данные
   *
   * @return object
   *
   * @throws PluginException
   */
  public function createInstance(string $plugin_id, array $configuration = []);
  
  /**
   * Интерфейс, который должны реализовывать все экземпляры этого плагина
   *
   * @return string
   */
  public function getInstanceInterface();

}
