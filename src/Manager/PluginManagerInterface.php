<?php

namespace Snr\Plugin\Manager;

use Snr\Plugin\Discovery\DiscoveryInterface;
use Snr\Plugin\Factory\FactoryInterface;

/**
 * Является универсальной точкой доступа к управлению плагинами,
 * объединяя в себе две обязательных для этого задачи:
 * 1. Реализует способ нахождения определений плагинов (DiscoveryInterface)
 * 2. Реализует способ создания экземпляров плагинов (FactoryInterface)
 *
 * @see DiscoveryInterface
 * @see FactoryInterface
 */
interface PluginManagerInterface extends DiscoveryInterface, FactoryInterface {

}
