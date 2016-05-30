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
    $hours = $this->config('happy_alexandrie.library_config')->get('opening_hours');
    $content = [
      '#type' => 'markup',
      '#markup' => $this->t('Hello world! Opening hours: @opening_hours', ['@opening_hours' => $hours])
    ];
    return $content;
  }
}
