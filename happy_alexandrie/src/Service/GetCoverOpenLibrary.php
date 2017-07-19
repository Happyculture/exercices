<?php

namespace Drupal\happy_alexandrie\Service;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Url;

/**
 * Class RemoteCoverService.
 */
class GetCoverOpenLibrary implements GetCoverServiceInterface {

  const PATTERN = 'http://covers.openlibrary.org/b/isbn/@isbn-@size.jpg';

  /**
   * {@inheritdoc}
   */
  public function getCover($isbn, $size = 'L') {
    $params = [
      '@isbn' => preg_replace('/[^0-9x]/i', '', $isbn),
      '@size' => $size,
    ];
    return Url::fromUri(new FormattableMarkup(self::PATTERN, $params));
  }

}
