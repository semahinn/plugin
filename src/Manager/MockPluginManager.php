<?php

namespace Snr\Plugin\Manager;

use Snr\Plugin\MockKernel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class MockPluginManager extends DefaultPluginManager {

  /**
   * @return EventDispatcherInterface
   */
  public function getEventDispatcher() {
    return MockKernel::getContainer()->get('event_dispatcher');
  }

}