<?php

namespace Drupal\happy_alexandrie\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Session\AccountInterface;
use Drupal\happy_alexandrie\Form\AlexandrieConfigForm;

class AlexandrieAccess {

  const DATE_FORMAT = 'G:i';

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
    $config = \Drupal::config('happy_alexandrie.library_config');
    $hour_opening = DrupalDateTime::createFromFormat(AlexandrieConfigForm::DATE_FORMAT, $config->get('opening'))->format(self::DATE_FORMAT);
    $hour_closing = DrupalDateTime::createFromFormat(AlexandrieConfigForm::DATE_FORMAT, $config->get('closing'))->format(self::DATE_FORMAT);

    $time = time();
    if ($time >= strtotime('today ' . $hour_opening) && $time <= strtotime('today ' . $hour_closing)) {
      return AccessResult::allowed();
    }
    return AccessResult::allowedIfHasPermission($account, 'administer alexandrie library');
  }

}
