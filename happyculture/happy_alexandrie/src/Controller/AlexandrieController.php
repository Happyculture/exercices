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
    $content = [
      '#type' => 'markup',
      '#markup' => $this->t('Hello world!')
    ];
    return $content;
  }
}
