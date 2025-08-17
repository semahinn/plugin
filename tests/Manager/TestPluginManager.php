<?php

namespace Snr\Plugin\Tests\Manager;

use Snr\Plugin\Plugin;
use Snr\Plugin\Tests\Plugin\TestPluginInterface;
use Snr\Plugin\Tests\TestKernel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Snr\Plugin\Manager\DefaultPluginManager;

final class TestPluginManager extends DefaultPluginManager {

  /**
   * @param array $namespaces
   *  Пространства имён, в которых будет осуществляться поиск
   */
  public function __construct(array $namespaces = []) {
    parent::__construct('Plugin', $namespaces, TestPluginInterface::class, Plugin::class);
  }

  /**
   * @return EventDispatcherInterface
   */
  public function getEventDispatcher() {
    return TestKernel::getContainer()->get('event_dispatcher');
  }

}