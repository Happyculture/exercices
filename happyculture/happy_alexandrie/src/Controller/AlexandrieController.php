<?php

/**
 * @file
 * Contains Drupal\happy_alexandrie\Controller\AlexandrieController.
 */

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Controller\ControllerBase;

class AlexandrieController extends ControllerBase {
  /**
   * Say hello to the world.
   *
   * @return string
   *   Return "Hello world!" string.
   */
  public function helloWorld() {
    $opening = $this->config('happy_alexandrie.library_config')->get('opening_hour');
    $closing = $this->config('happy_alexandrie.library_config')->get('closing_hour');
    $content = [
      '#type' => 'markup',
      '#markup' => $this->t('Hello world! Opening hour: @opening_hour / Closing Hour: @closing_hour', [
        '@opening_hour' => $opening,
        '@closing_hour' => $closing
      ])
    ];
    return $content;
  }
}
