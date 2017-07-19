<?php

namespace Drupal\isbn\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'isbn' field type.
 *
 * @FieldType(
 *   id = "isbn",
 *   label = @Translation("ISBN"),
 *   description = @Translation("Stores ISBN 10 and ISBN 13 identifiers."),
 *   default_widget = "isbn_default",
 *   default_formatter = "isbn"
 * )
 */
class IsbnItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['isbn_10'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('ISBN 10'));

    $properties['isbn_13'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('ISBN 13'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'isbn_10' => [
          'type' => 'varchar',
          'length' => 13,
        ],
        'isbn_13' => [
          'type' => 'varchar',
          'length' => 17,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'isbn_13';
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return empty($this->get('isbn_13')->getValue());
  }

}
