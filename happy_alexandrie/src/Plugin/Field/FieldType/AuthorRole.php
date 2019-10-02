<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Author and role field type.
 *
 * @FieldType(
 *   id = "author_role",
 *   label = @Translation("Author & role"),
 *   category = @Translation("Reference"),
 *   default_widget = "author_role_widget",
 *   default_formatter = "entity_reference_label",
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class AuthorRole extends EntityReferenceItem {

  /**
   * Override the field schema to store our new role attribute.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    // Adding to the parent schema definition our column.
    $schema['columns']['role'] = [
      'description' => 'Author role for the book',
      'type' => 'varchar',
      'length' => 255,
    ];
    return $schema;
  }

  /**
   * Expose to Drupal the attribute that can be fetched when loading the field.
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_storage_definition) {
    $properties = parent::propertyDefinitions($field_storage_definition);

    // Add the role property to the current definition of the entity reference.
    $properties['role'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Author role'))
      ->setRequired(TRUE);
    return $properties;
  }
}
