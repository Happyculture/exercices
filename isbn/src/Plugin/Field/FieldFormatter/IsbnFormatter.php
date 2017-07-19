<?php

namespace Drupal\isbn\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'isbn' formatter.
 *
 * @FieldFormatter(
 *   id = "isbn",
 *   label = @Translation("ISBN"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class IsbnFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $prop_name = $item->mainPropertyName();
      $elements[$delta] = ['#markup' => $item->{$prop_name}];
    }

    return $elements;
  }

}
