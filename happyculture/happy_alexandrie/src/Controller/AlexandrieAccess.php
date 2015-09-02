<?php

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class AlexandrieAccess {
  /**
   * Limit access to the Library between 9:00 and 18:30.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function accessLibrary(AccountInterface $account) {
    if (time() >= strtotime('today 9:00') && time() <= strtotime('today 18:30')) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }
}
