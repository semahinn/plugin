<?php

namespace Snr\Plugin\Tests\Manager;

use Snr\Plugin\Tests\TestKernel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Snr\Plugin\Manager\DefaultPluginManager;

final class TestPluginManager extends DefaultPluginManager {

  /**
   * @return EventDispatcherInterface
   */
  public function getEventDispatcher() {
    return TestKernel::getContainer()->get('event_dispatcher');
  }

}