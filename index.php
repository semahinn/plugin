<?php

use Snr\Plugin\Plugin\ExamplePluginInterface;
use Snr\Plugin\Manager\DefaultPluginManager;

$dir = dirname(__FILE__);
require_once "$dir/vendor/autoload.php";

// Example
$namespaces = [
  "Snr\Plugin" => "$dir/src"
];

$plugin_manager = new DefaultPluginManager('Plugin', $namespaces, ExamplePluginInterface::class);
$plugin_manager->setEventDispatcher(new \Symfony\Component\EventDispatcher\EventDispatcher());
$definitions = $plugin_manager->getDefinitions();

$instances = [];
foreach ($definitions as $id => $definition) {
  $instances[$id] = $plugin_manager->createInstance($id, ['phrase' => 'Hello world'], $definition);
}

return;