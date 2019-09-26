<?php

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Controller\ControllerBase;

class AlexandrieController extends ControllerBase {

  /**
   * /welcome route callback.
   *
   * @return array
   *   The render array of the page.
   */
  public function helloWorld() {
    return [
      '#markup' => $this->t('Welcome into the Great Library'),
    ];
  }

  /**
   * /welcome/name route callback.
   *
   * @param string $name
   *   The name of the visitor to show.
   *
   * @return array
   *   The render array of the page.
   */
  public function helloWorldParam($name) {
    return [
      '#markup' => $this->t('Welcome @name into the Great Library', ['@name' => $name]),
    ];
  }
}
