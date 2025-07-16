<?php

namespace Snr\Plugin\Tests;

use PHPUnit\Framework\TestCase;
use Snr\Plugin\MockKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Snr\Plugin\Adapter\SymfonyContainerAdapter;
use Snr\Plugin\Manager\DefaultPluginManager;
use Snr\Plugin\Plugin\ExamplePluginInterface;

class PluginManagerTest extends TestCase {

  public function testCreatePlugins() {

    $root = dirname(__FILE__, 2);
    require_once "$root/vendor/autoload.php";
    $namespaces = [
      "Snr\Plugin" => "$root/src"
    ];

    $container = new ContainerBuilder();
    $container->register('event_dispatcher', new EventDispatcher());

    $plugin_manager = new DefaultPluginManager('Plugin', $namespaces, ExamplePluginInterface::class);
    $container->register('plugin.manager.default', $plugin_manager);

    $container->compile();

    $adapter = new SymfonyContainerAdapter($container);
    MockKernel::setContainer($adapter);

    $instances = [];
    $definitions = $plugin_manager->getDefinitions();
    foreach ($definitions as $id => $definition) {
      $instances[$id] = $plugin_manager->createInstance($id, ['phrase' => 'Hello world'], $definition);
    }

    $this->assertCount(1, $instances, "Должен создаться один экземпляр плагина");
    $instance = current($instances);
    $plugin_manager_from_instance = $instance->getPluginManager();

    $this->assertInstanceOf(ExamplePluginInterface::class, $instance,
      "Экземпляр плагина должен быть " . ExamplePluginInterface::class);
    $this->assertObjectHasProperty('phrase', $instance,
      "Экземпляр плагина должен иметь свойство 'phrase'");
    $this->assertEquals('Hello world', $instance->phrase,
      "Свойство 'phrase' должно быть строкой 'Hello world'");
  }

}