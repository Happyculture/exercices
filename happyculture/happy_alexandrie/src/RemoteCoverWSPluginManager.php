<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\RemoteCoverWSPluginManager.
 */

namespace Drupal\happy_alexandrie;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Provides a plugin manager to get remote cover.
 *
 * @see \Drupal\happy_alexandrie\RemoteCoverWSPluginBase
 * @see \Drupal\happy_alexandrie\RemoteCoverWSInterface
 * @see plugin_api
 */
class RemoteCoverWSPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new RemoteCoverWSPluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/RemoteCoverWS',
      $namespaces,
      $module_handler,
      'Drupal\happy_alexandrie\RemoteCoverWSInterface',
      'Drupal\happy_alexandrie\Annotation\RemoteCoverWS'
    );

    $this->alterInfo('remote_cover_info');
    $this->setCacheBackend($cache_backend, 'remote_cover_plugins');
  }

}
