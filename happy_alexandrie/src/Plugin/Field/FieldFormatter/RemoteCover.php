<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\isbn\Plugin\Field\FieldFormatter\IsbnFormatter;

/**
 * Plugin implementation of the 'remote_cover' formatter.
 *
 * @FieldFormatter(
 *   id = "remote_cover",
 *   label = @Translation("Remote cover"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class RemoteCover extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'remote_cover',
        '#isbn' => $item->value,
        '#title' => $items->getEntity()->label(),
      ];
    }

    return $elements;
  }

}
