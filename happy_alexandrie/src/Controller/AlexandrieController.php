<?php

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Controller\ControllerBase;

class AlexandrieController extends ControllerBase {

  /**
   * /welcome route callback.
   *
   * @param string $name
   *   The name of the visitor to show.
   *
   * @return array
   *   The render array of the page.
   */
  public function helloWorld($name) {
    $build = [];

    $build['intro'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('Welcome @name into the Great Library', ['@name' => $name]),
    ];

    $config = $this->config('happy_alexandrie.library_config');
    $params = [
      '%opening' => $config->get('opening'),
      '%closing' => $config->get('closing'),
    ];
    $build['schedule'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('The library opens at %opening and closes at %closing.', $params),
    ];

    return $build;
  }

}
