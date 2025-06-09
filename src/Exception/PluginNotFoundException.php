<?php

namespace Snr\Plugin\Exception;

class PluginNotFoundException extends PluginException {
  
  /**
   * @param string $plugin_id
   * @param string $message
   * @param int $code
   * @param \Exception|NULL $previous
   */
  public function __construct(string $plugin_id, string $message = '', int $code = 0, \Exception $previous = NULL) {
    if (empty($message)) {
      $message = "Плагин с идентификатором '$plugin_id' не найден";
    }
    parent::__construct($message, $code, $previous);
  }

}
