<?php

namespace Drupal\author_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Author type entity.
 *
 * @ConfigEntityType(
 *   id = "author_type",
 *   label = @Translation("Author type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\author_entity\AuthorTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\author_entity\Form\AuthorTypeForm",
 *       "edit" = "Drupal\author_entity\Form\AuthorTypeForm",
 *       "delete" = "Drupal\author_entity\Form\AuthorTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\author_entity\AuthorTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "author_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "author",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/author_type/{author_type}",
 *     "add-form" = "/admin/structure/author_type/add",
 *     "edit-form" = "/admin/structure/author_type/{author_type}/edit",
 *     "delete-form" = "/admin/structure/author_type/{author_type}/delete",
 *     "collection" = "/admin/structure/author_type"
 *   }
 * )
 */
class AuthorType extends ConfigEntityBundleBase implements AuthorTypeInterface {

  /**
   * The Author type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Author type label.
   *
   * @var string
   */
  protected $label;

}
