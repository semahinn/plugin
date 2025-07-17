<?php

namespace Snr\Plugin\Plugin;

use Snr\Plugin\Manager\PluginManagerInterface;

interface PluginableInstanceInterface {
  
  /**
   * @return PluginManagerInterface
   */
  public function getPluginManager();

}