<?php

/**
 * @file
 * Contains \Drupal\isbn\Plugin\Field\FieldType\IsbnItem.
 */

namespace Drupal\isbn\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'isbn' field type.
 *
 * @FieldType(
 *   id = "isbn",
 *   label = @Translation("Isbn"),
 *   description = @Translation("Stores a ISBN string in various format."),
 *   default_widget = "isbn_default",
 *   default_formatter = "isbn",
 * )
 */
class IsbnItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['isbn_13'] = DataDefinition::create('string')
      ->setLabel(t('ISBN-13'))
      ->addConstraint('Length', array('max' => 13, 'min' => 13))
      ->setDescription(t('The 13 chars long version of the ISBN.'));

    $properties['isbn_10'] = DataDefinition::create('string')
      ->setLabel(t('ISBN-10'))
      ->addConstraint('Length', array('max' => 10, 'min' => 10))
      ->setDescription(t('The 10 chars long version of the ISBN.'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'isbn_13' => array(
          'description' => 'The isbn number with 13 digits.',
          'type' => 'varchar',
          'length' => 13,
        ),
        'isbn_10' => array(
          'description' => 'The isbn number with 10 digits.',
          'type' => 'varchar',
          'length' => 10,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $isbns = array(
      array('isbn_13' => '9785699470594', 'isbn_10' => '569947059X'),
      array('isbn_13' => '9783827326089', 'isbn_10' => '3827326087'),
      array('isbn_13' => '9780470429037', 'isbn_10' => '0470429038'),
      array('isbn_13' => '9780470549674', 'isbn_10' => '047054967X'),
    );
    return array_rand($isbns);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('isbn_13')->getValue();
    return empty($value);
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'isbn_13';
  }
}
