<?php

namespace Drupal\happy_alexandrie\Service;

/**
 * Interface RemoteCoverServiceInterface.
 */
interface GetCoverServiceInterface {

  /**
   * Gets the cover URL from its ISBN and size.
   *
   * @param string $isbn
   *   The ISBN.
   * @param string $size
   *   The requested site. Should be S, M or L.
   *
   * @return \Drupal\Core\Url
   *   The cover Url.
   */
  public function getCover($isbn, $size);

}
