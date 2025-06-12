<?php

namespace Snr\Plugin\Factory;

use Snr\Plugin\Discovery\DiscoveryInterface;
use Snr\Plugin\Exception\PluginException;

/**
 * Предназначено для создания экземпляров плагинов
 */
class DefaultFactory implements FactoryInterface {

  /**
   * @var DiscoveryInterface
   */
  protected $discovery;

  /**
   * @see FactoryInterface::getInstanceInterface()
   *
   * @var string
   */
  protected $interface;

  /**
   * @param DiscoveryInterface $discovery
   *
   * @param string $plugin_interface
   *  Интерфейс, который должны реализовывать все экземпляры этого плагина
   */
  public function __construct(DiscoveryInterface $discovery, string $plugin_interface) {
    $this->discovery = $discovery;
    $this->interface = $plugin_interface;
  }

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = []) {
    $plugin_definition = $this->discovery->getDefinition($plugin_id);
    $plugin_class = static::getPluginClass($plugin_id, $plugin_definition, $this->interface);
    return new $plugin_class($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * Находит класс плагина на основе информации об определении плагина
   *  @see DiscoveryInterface::getDefinition()
   *
   * @param string $plugin_id
   *  Идентификатор плагина
   *
   * @param array|null $plugin_definition
   *  Определение плагина
   *
   * @param string|null $plugin_interface
   *  Интерфейс, который должны реализовывать все экземпляры этого плагина
   *
   * @return string
   *  Класс плагина
   *
   * @throws PluginException
   *  Порождается, когда класс плагина не был найден, класс не существует,
   *  или класс не реализует требуемый интерфейс
   */
  public static function getPluginClass(string $plugin_id, array $plugin_definition = NULL, string $plugin_interface = NULL) {
    $missing_class_message = sprintf('Для плагина (%s) не найден класс.', $plugin_id);
    if (empty($plugin_definition['class']) || !is_array($plugin_definition))
      throw new PluginException($missing_class_message);
    
    $class = $plugin_definition['class'];
    if (!class_exists($class)) {
      throw new PluginException(sprintf('Найденный для плагина (%s) класс "%s" не существует.', $plugin_id, $class));
    }

    if ($plugin_interface && !is_subclass_of($class, $plugin_interface)) {
      throw new PluginException(sprintf('Класс плагина "%s" (%s) не реализует интерфейс %s.', $plugin_id, $class, $plugin_interface));
    }

    return $class;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getInstanceInterface(): string {
    return $this->interface;
  }
}
