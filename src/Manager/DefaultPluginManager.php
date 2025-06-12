<?php

namespace Snr\Plugin\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Snr\Plugin\Discovery\AnnotatedClassDiscovery;
use Snr\Plugin\Discovery\DiscoveryInterface;
use Snr\Plugin\Discovery\DiscoveryCachedTrait;
use Snr\Plugin\Event\AlterPluginDefinitionsEvent;
use Snr\Plugin\Factory\DefaultFactory;
use Snr\Plugin\Factory\FactoryInterface;

/**
 * Мэнеджер плагинов по-умолчанию
 * Может как использоваться напрямую, так и являться
 * отправной точкой для создания своих реализаиий PluginManagerInterface
 */
class DefaultPluginManager implements PluginManagerInterface, ByPluginClassInterface {
  
  use DiscoveryCachedTrait;
  use ByPluginClassTrait;
  
  /**
   * @var string
   */
  protected $subdir;
  
  /**
   * @var array
   */
  protected $namespaces;
  
  /**
   * @var string
   */
  protected $pluginDefinitionAnnotationName;
  
  /**
   * @see FactoryInterface::getInstanceInterface()
   *
   * @var string
   */
  protected $pluginInterface;
  
  /**
   * @var DiscoveryInterface
   */
  protected $discovery;
  
  /**
   * @var FactoryInterface
   */
  protected $factory;
  
  /**
   * @var EventDispatcherInterface
   */
  protected $eventDispatcher;
  
  public function __construct(string $subdir, array $namespaces, string $plugin_interface, $plugin_definition_annotation_name = 'Snr\Plugin\Plugin') {
    $this->subdir = $subdir;
    $this->namespaces = $namespaces;
    $this->pluginDefinitionAnnotationName = $plugin_definition_annotation_name;
    $this->pluginInterface = $plugin_interface;
  }
  
  /**
   * {@inheritdoc}
   */
  public function createInstance(string $plugin_id, array $configuration = []) {
    return $this->getFactory()->createInstance($plugin_id, $configuration);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getInstanceInterface(): string {
    return $this->pluginInterface;
  }
  
  /**
   * @return DiscoveryInterface
   */
  protected function getDiscovery() {
    if (!$this->discovery) {
      $this->discovery = new AnnotatedClassDiscovery($this->subdir, $this->namespaces, $this->pluginDefinitionAnnotationName);
    }
    return $this->discovery;
  }
  
  /**
   * @return FactoryInterface
   */
  protected function getFactory() {
    if (!$this->factory) {
      $this->factory = new DefaultFactory($this, $this->pluginInterface);
    }
    return $this->factory;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getDefinition($plugin_id, $exception_on_invalid = TRUE): ?array {
    return $this->getDiscovery()->getDefinition($plugin_id, $exception_on_invalid);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getDefinitions(): array {
    // TODO: Добавить взаимодействия с psr16 кэшем
    // (Например, это могут быть специальные функции getFromCache и setInCache)
    
    // $definitions = $this->getFromCache();
    if (!isset($definitions)) {
      $definitions = $this->findDefinitions();
      // $this->setInCache($definitions);
    }
    return $definitions;
  }
  
  /**
   * @return array
   *  Возвращает определения плагинов
   */
  protected function findDefinitions() {
    $definitions = $this->getDiscovery()->getDefinitions();
    $event = new AlterPluginDefinitionsEvent($definitions);
    $this->eventDispatcher->dispatch($event);
    return $this->getDiscovery()->getDefinitions();
  }
  
  /**
   * Можно установить любой EventDispatcher
   * Необходим для вызова событий (@see AlterPluginDefinitionsEvent),
   * возникающих в процессе поиска определений плагинов
   *
   * @param EventDispatcherInterface $dispatcher
   *
   * @return void
   */
  public function setEventDispatcher(EventDispatcherInterface $dispatcher) {
    $this->eventDispatcher = $dispatcher;
  }
  
}