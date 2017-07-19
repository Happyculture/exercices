<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\isbn\Plugin\Field\FieldFormatter\IsbnFormatter;

/**
 * Plugin implementation of the 'remote_cover' formatter.
 *
 * @FieldFormatter(
 *   id = "remote_cover",
 *   label = @Translation("Remote cover"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class RemoteCover extends IsbnFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $prop_name = $item->mainPropertyName();
      $elements[$delta] = [
        '#theme' => 'remote_cover',
        '#isbn' => $item->{$prop_name},
        '#title' => $items->getEntity()->label(),
      ];
    }

    return $elements;
  }

}
