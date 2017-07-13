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
    return [
      '#markup' => $this->t('Welcome @name into the Great Library', ['@name' => $name]),
    ];
  }

}
