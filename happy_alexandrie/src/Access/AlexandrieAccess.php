<?php

namespace Drupal\happy_alexandrie\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

class AlexandrieAccess {

  /**
   * Limit access to the Library between 9:00 and 18:30 except for admins.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface The access result.
   *   The access result.
   */
  public function accessLibrary(AccountInterface $account) {
    $time = time();
    if ($time >= strtotime('today 9:00') && $time <= strtotime('today 18:30')) {
      return AccessResult::allowed();
    }
    return AccessResult::allowedIfHasPermission($account, 'administer alexandrie library');
  }

}
