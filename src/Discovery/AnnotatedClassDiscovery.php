<?php

namespace Snr\Plugin\Discovery;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use ReflectionClass;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Snr\Psr16cache\FileCacheFactory;
use Snr\Psr16cache\FileCacheInterface;

/**
 * Здесь ОПРЕДЕЛЕНИЕ ПЛАГИНА описывается с помощью
 * прикрепляемого к классу DocBlock комментария, называемого аннотацией
 *
 * ОПРЕДЕЛЕНИЕ ПЛАГИНА - свойства из аннотации,
 * которой был отмечен определённый КЛАСС ПЛАГИНА
 *
 * КЛАСС АННОТАЦИИ - класс (Например, @see \Snr\Plugin\Plugin),
 * в котором описываются все свойства (id, label и т.д.) ОПРЕДЕЛЕНИЯ ПЛАГИНА
 *
 * КЛАСС ПЛАГИНА - класс (Например, @see \Snr\Plugin\Plugin\ExamplePlugin),
 * который был найден, потому что был отмечен аннотацией
 */
class AnnotatedClassDiscovery implements DiscoveryInterface {

  use DiscoveryTrait;

  /**
   * Переданные psr-4 пространства имён, среди
   *  которых происходит поиск КЛАССОВ ТИПОВ (ПЛАГИНОВ)
   *
   * @var string[]
   */
  protected $pluginNamespaces;

  /**
   * Класс аннотации
   *
   * @var string
   */
  protected $pluginDefinitionAnnotationName;

  /**
   * @var SimpleAnnotationReader
   */
  protected $annotationReader;

  /**
   * Экземпляр файлового кэша
   *
   * @var FileCacheInterface
   */
  protected $fileCache;
  
  /**
   * @var string
   */
  protected $directorySuffix;
  
  /**
   * @var string
   */
  protected $namespaceSuffix;
  
  /**
   * @param string $subdir
   * @param array $plugin_namespaces
   * @param string $plugin_definition_annotation_name
   */
  public function __construct(string $subdir,
                              array $plugin_namespaces,
                              string $plugin_definition_annotation_name = 'Snr\Plugin\Plugin') {
    if ($subdir) {
      if ('/' !== $subdir[0]) {
        $subdir = '/' . $subdir;
      }
      $this->directorySuffix = $subdir;
      $this->namespaceSuffix = str_replace('/', '\\', $subdir);
    }
    
    $this->pluginNamespaces = $plugin_namespaces;
    $this->pluginDefinitionAnnotationName = $plugin_definition_annotation_name;
    $file_cache_suffix = str_replace('\\', '_', $plugin_definition_annotation_name);
    $this->fileCache = (new FileCacheFactory('awesome_id'))
      ->get('annotated_class_discovery:' . $file_cache_suffix);
  }

  /**
   * @return Reader
   */
  protected function getAnnotationReader() {
    if (!isset($this->annotationReader)) {
      $this->annotationReader = new SimpleAnnotationReader();

      // Add the namespaces from the main plugin annotation
      $namespace = substr($this->pluginDefinitionAnnotationName, 0, strrpos($this->pluginDefinitionAnnotationName, '\\'));
      $this->annotationReader->addNamespace($namespace);
    }
    return $this->annotationReader;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $definitions = [];

    $reader = $this->getAnnotationReader();
    
    AnnotationRegistry::reset();
    AnnotationRegistry::registerLoader('class_exists');
    
    foreach ($this->getPluginNamespaces() as $namespace => $dir) {
      if (file_exists($dir)) {
        $iterator = new \RecursiveIteratorIterator(
          new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileinfo) {
          if ($fileinfo->getExtension() == 'php') {
            if ($cached = $this->fileCache->get($fileinfo->getPathName())) {
              if (isset($cached['id'])) {
                $definitions[$cached['id']] = unserialize($cached['content']);
              }
              continue;
            }

            $sub_path = $iterator->getSubIterator()->getSubPath();
            $sub_path = $sub_path ? str_replace(DIRECTORY_SEPARATOR, '\\', $sub_path) . '\\' : '';
            $class = $namespace . '\\' . $sub_path . $fileinfo->getBasename('.php');
            $reflection_class = new ReflectionClass($class);

            if ($annotation = $reader->getClassAnnotation($reflection_class, $this->pluginDefinitionAnnotationName)) {
              $id = $annotation->id;
              $values = [
                'id' => $id,
                'label' => $annotation->label,
                'class' => $class
              ];
              $definitions[$id] = $values;
              $this->fileCache->set($fileinfo->getPathName(), ['id' => $id, 'content' => serialize($values)]);
            }
            else {
              $this->fileCache->set($fileinfo->getPathName(), [NULL]);
            }
          }
        }
      }
    }
    
    AnnotationRegistry::reset();

    return $definitions;
  }

  /**
   * Переданные psr-4 пространства имён, среди
   *  которых происходит поиск КЛАССОВ ПЛАГИНОВ
   *
   * @return string[]
   */
  protected function getPluginNamespaces() {
    $plugin_namespaces = [];
    if ($this->namespaceSuffix) {
      // Пример:
      // $namespace - Snr\MyModule
      // $dir - snr/MyModule/src
      // namespaceSuffix - Field
      // Snr\MyModule\Field => snr/MyModule/src/Field
      foreach ($this->pluginNamespaces as $namespace => $dir) {
        $namespace .= $this->namespaceSuffix;
        $plugin_namespaces[$namespace] = $dir . $this->directorySuffix;
      }
    }
    return $plugin_namespaces;
  }
}
