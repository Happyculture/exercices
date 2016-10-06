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
   * @param $isbn
   *   The ISBN of the item we want to retrieve the cover from.
   *
   * @return string
   *   An url of the image cover.
   */
  public function getCover($isbn);
}
