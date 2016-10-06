<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\Service\GetCoverService.
 *
 * This code is used in the training exercise about services. It become useless
 * once the RemoteCover Plugin type is created.
 */

namespace Drupal\happy_alexandrie\Service;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Url;

/**
 * Class GetCoverService.
 *
 * @package Drupal\happy_alexandrie\Service
 */
class GetCoverService implements GetCoverServiceInterface {
  /**
   * The webservice url.
   *
   * @var string
   */
  protected $webservice_url;

  /**
   * GetCoverService constructor.
   */
  public function __construct() {
    $this->webservice_url = 'http://covers.openlibrary.org/b/isbn/@isbn-@size.jpg';
  }

  /**
   * Helper function to get a cover.
   *
   * @param $param
   *   A parameter used by the service to get the cover.
   * @return string
   *   An url of the image cover.
   */
  public function getCover($isbn, $size = 'M') {
    $url = new FormattableMarkup($this->webservice_url, array('@isbn' => $isbn, '@size' => $size));
    return  Url::fromUri($url);
  }
}
