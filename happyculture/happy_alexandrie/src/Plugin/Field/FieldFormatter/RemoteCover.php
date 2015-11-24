<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCover.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
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
  public function prepareView(array $entities_items) {
    foreach ($entities_items as $items) {
      foreach ($items as $item) {
        $item->undashed_value = str_replace('-', '', $item->value);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $build = [];

    foreach ($items as $item) {
      $cover = new FormattableMarkup('@isbn<br /><img src="http://covers.openlibrary.org/b/isbn/@undashed_isbn-L.jpg" alt="" />', [
        '@isbn' => $item->value,
        '@undashed_isbn' => $item->undashed_value,
      ]);
      $build[] = [
        '#markup' => $cover,
      ];
    }

    return $build;
  }

}
