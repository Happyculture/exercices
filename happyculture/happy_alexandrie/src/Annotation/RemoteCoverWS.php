<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\Annotation\RemoteCoverWS.
 */

namespace Drupal\happy_alexandrie\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a remote cover webservice item annotation object.
 *
 * Plugin Namespace: Plugin\happy_alexandrie\RemoteCoverWS
 *
 * For a working example, see \Drupal\happy_alexandrie\Plugin\RemoteCoverWS\GoogleRemoteCover
 *
 * @see \Drupal\happy_alexandrie\RemoteCoverWSPluginBase
 * @see \Drupal\happy_alexandrie\RemoteCoverWSInterface
 * @see \Drupal\happy_alexandrie\RemoteCoverWSPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class RemoteCoverWS extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The name of the webservice.
   *
   * @var string
   */
  public $name;

}
