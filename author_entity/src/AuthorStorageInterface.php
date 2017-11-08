<?php

namespace Drupal\author_entity;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\author_entity\Entity\AuthorInterface;

/**
 * Defines the storage handler class for Author entities.
 *
 * This extends the base storage class, adding required special handling for
 * Author entities.
 *
 * @ingroup author_entity
 */
interface AuthorStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Author revision IDs for a specific Author.
   *
   * @param \Drupal\author_entity\Entity\AuthorInterface $entity
   *   The Author entity.
   *
   * @return int[]
   *   Author revision IDs (in ascending order).
   */
  public function revisionIds(AuthorInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Author author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Author revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\author_entity\Entity\AuthorInterface $entity
   *   The Author entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(AuthorInterface $entity);

  /**
   * Unsets the language for all Author with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
