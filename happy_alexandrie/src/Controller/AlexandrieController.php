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

}
