<?php

namespace Snr\Plugin\Discovery;

/**
 * Описывает минимальный набор методов для получения ОПРЕДЕЛЕНИЙ (ПЛАГИНОВ)
 *
 * ОПРЕДЕЛЕНИЕ ПЛАГИНА - набор свойств (метаданных),
 * которыми был отмечен определённый КЛАСС (ПЛАГИНА)
 *
 * В php есть два основных подхода к поиску классов плагинов -
 *
 * @see AnnotatedClassDiscovery
 * @see AttributedClassDiscovery
 */
interface DiscoveryInterface {

  /**
   * Возвращает определение плагина
   *
   * @param string $plugin_id
   *  Идентификатор плагина
   *
   * @param bool $exception_on_invalid
   *  Если true, то порождает исключение, если
   *  такой плагин не был найден
   *
   * @return array|null
   *  Массив определения плагина или null,
   *  если такой плагин не был найден
   *
   * @throws
   */
  public function getDefinition(string $plugin_id, bool $exception_on_invalid = TRUE): ?array;

  /**
   * Возвращает все определения плагинов
   *
   * @return array
   */
  public function getDefinitions(): array;

  /**
   * Проверяет, существует ли плагин
   * с таким идентификатором или нет
   *
   * @param string $plugin_id
   *  Идентификатор плагина
   *
   * @return bool
   */
  public function hasDefinition(string $plugin_id): bool;
}
