<?php

namespace Snr\Plugin\Manager;

interface ByPluginClassInterface {
  
  /**
   * @param string $type
   *
   * @return string
   */
  public function getPluginClass(string $type);
  
  /**
   * Для определённого класса можно определить,
   * является ли он классом плагином
   *
   * @param string $class
   *  Полное имя класса
   *
   * @return array|null
   *  Определение плагина, если этот класс является плагином,
   *  и null в других случаях
   */
  public function getDefinitionByPluginClass(string $class);

}
