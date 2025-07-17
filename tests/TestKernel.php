<?php

namespace Snr\Plugin\Tests;

use Psr\Container\ContainerInterface;

class TestKernel {

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