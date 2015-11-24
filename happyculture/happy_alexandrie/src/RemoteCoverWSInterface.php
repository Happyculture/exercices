<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\RemoteCoverWSInterface.
 */

namespace Drupal\happy_alexandrie;

/**
 * Defines an interface for Remote Cover Webservice items.
 *
 * @see plugin_api
 */
interface RemoteCoverWSInterface {

  /**
   * Used for returning values by key.
   *
   * @var string
   *   The webservice url to ask for a cover.
   */
  public function buildWebserviceUrl($webservice_url);

  /**
   * Call the web service with the good parameter to get the cover image url.
   *
   * @var string
   *   The parameter used by the service to get the url of a cover. An isbn
   *   number most of the time.
   *
   * @return string
   *   An url of the image cover.
   */
  public function getCover($param);
}
