<?php

namespace Snr\Plugin\Adapter;

use Psr\Container\ContainerInterface;

abstract class ContainerAdapter implements ContainerInterface {

  /**
   * Любой экземпляр, совместимый с psr-11 контейнером
   *
   * @var mixed
   */
  protected $realContainer;

  public function __construct($real_container) {
    $this->realContainer = $real_container;
  }

  public function getRealContainer() {
    return $this->realContainer;
  }

}