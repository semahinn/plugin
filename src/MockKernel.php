<?php

namespace Snr\Plugin;

use Psr\Container\ContainerInterface;

class MockKernel {

  /**
   * @var ContainerInterface
   */
  protected static $container;

  /**
   * @param ContainerInterface|null $container
   */
  public static function setContainer(?ContainerInterface $container) {
    static::$container = $container;
  }

  /**
   * @return ContainerInterface
   */
  public static function getContainer() {
    return static::$container;
  }
}