<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\Service\GetCoverServiceInterface.
 *
 * This code is used in the training exercise about services. It become useless
 * once the RemoteCover Plugin type is created.
 */

namespace Drupal\happy_alexandrie\Service;

/**
 * Get Cover Service interface methods.
 */
interface GetCoverServiceInterface {

  /**
   * Helper function to get a cover.
   *
   * @param $param
   *   A parameter used by the service to get the cover.
   * @return string
   *   An url of the image cover.
   */
  public function getCover($param);
}
