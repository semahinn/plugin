<?php

namespace Snr\Plugin\Manager;

use Psr\Container\ContainerInterface;

/**
 * Позволяет обращаться к сервис контейнеру (ContainerInterface)
 * из нашего экземпляра PluginManagerInterface
 */
interface ContainerAwarePluginManagerInterface extends PluginManagerInterface {

  /**
   * @param ContainerInterface $container
   *
   * @return static
   */
  public function setContainer(ContainerInterface $container);

  /**
   * @return ContainerInterface
   */
  public function getContainer();

}
