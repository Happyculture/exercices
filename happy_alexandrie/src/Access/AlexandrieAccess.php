<?php

namespace Drupal\happy_alexandrie\Access;

use Drupal\Core\Access\AccessResult;

class AlexandrieAccess {

  /**
   * Limit access to the Library between 9:00 and 18:30.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function accessLibrary() {
    $time = time();
    if ($time >= strtotime('today 9:00') && $time <= strtotime('today 18:30')) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }

}
