<?php

namespace Drupal\author_entity\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\author_entity\AuthorEntityInterface;
use Zend\Stdlib\DateTime;

/**
 * Defines the Author entity.
 *
 * @ingroup author_entity
 *
 * @ContentEntityType(
 *   id = "author_entity",
 *   label = @Translation("Author"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\author_entity\AuthorEntityListBuilder",
 *     "views_data" = "Drupal\author_entity\Entity\AuthorEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\author_entity\Form\AuthorEntityForm",
 *       "add" = "Drupal\author_entity\Form\AuthorEntityForm",
 *       "edit" = "Drupal\author_entity\Form\AuthorEntityForm",
 *       "delete" = "Drupal\author_entity\Form\AuthorEntityDeleteForm",
 *     },
 *     "access" = "Drupal\author_entity\AuthorEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\author_entity\AuthorEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "author_entity",
 *   admin_permission = "administer author entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/author_entity/{author_entity}",
 *     "add-form" = "/admin/structure/author_entity/add",
 *     "edit-form" = "/admin/structure/author_entity/{author_entity}/edit",
 *     "delete-form" = "/admin/structure/author_entity/{author_entity}/delete",
 *     "collection" = "/admin/structure/author_entity",
 *   },
 *   field_ui_base_route = "author_entity.settings"
 * )
 */
class AuthorEntity extends ContentEntityBase implements AuthorEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getAge() {
    // Get the Author age.
    $birth = new DateTime($this->get('birth_date')->value);
    // Check if the author is dead. Otherwise evaluate is age against today.
    if ($this->get('death_date')->value) {
      $death = new DateTime($this->get('death_date')->value);
    }
    else {
      $death = new DateTime();
    }
    $age = $birth->diff($death);
    return $age->format('%y');
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Mandatory base fields for Content Entity Types.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Author entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Author entity.'))
      ->setReadOnly(TRUE);
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Author is published.'))
      ->setDefaultValue(TRUE);
    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Author entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);

    // Custom attributes.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The birth name of the Author.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['pseudonym'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Pseudonym'))
        ->setSettings(array(
            'max_length' => 50,
            'text_processing' => 0,
        ))
        ->setDefaultValue('')
        ->setDisplayOptions('view', array(
            'label' => 'hidden',
            'type' => 'string',
            'weight' => -3,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'string_textfield',
            'weight' => -3,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['birth_date'] = BaseFieldDefinition::create('datetime')
        ->setLabel(t('Birth date'))
        ->setDefaultValue('')
        ->setSetting('datetime_type', 'date')
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'datetime_default',
            'settings' => array(
              'format_type' => 'html_date',
            ),
            'weight' => -2,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'datetime_default',
            'weight' => -2,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['death_date'] = BaseFieldDefinition::create('datetime')
        ->setLabel(t('Death date'))
        ->setDefaultValue('')
        ->setSetting('datetime_type', 'date')
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'datetime_default',
            'settings' => array(
              'format_type' => 'html_date',
            ),
            'weight' => -1,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'datetime_default',
            'weight' => -1,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['picture'] = BaseFieldDefinition::create('image')
        ->setLabel(t('Picture'))
        ->setDefaultValue('')
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'image',
            'weight' => -1,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'image_image',
            'weight' => -1,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
