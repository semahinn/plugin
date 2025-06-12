<?php

namespace Snr\Plugin\Event;

use Symfony\Component\EventDispatcher\Event;

class AlterPluginDefinitionsEvent extends Event {
  
  const EVENT_NAME = 'plugin.alter.plugin_definitions';
  
  /**
   * @var array
   */
  public $definitions;
  
  public function __construct(array $definitions) {
    $this->definitions = $definitions;
  }
  
}