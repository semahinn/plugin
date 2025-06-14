<?php

namespace Snr\Plugin\Manager;

use Snr\Plugin\Discovery\DiscoveryInterface;
use Snr\Plugin\Factory\FactoryInterface;

/**
 * Является универсальной точкой доступа к управлению плагинами,
 * объединяя в себе две обязательных для этого задачи:
 * 1. (@see DiscoveryInterface) - реализует способ нахождения определений плагинов
 * 2. (@see FactoryInterface) - реализует способ создания экземпляров плагинов
 */
interface PluginManagerInterface extends DiscoveryInterface, FactoryInterface {

}
