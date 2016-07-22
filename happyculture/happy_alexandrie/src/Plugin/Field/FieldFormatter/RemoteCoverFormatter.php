<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCoverFormatter.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Component\Render\FormattableMarkup;
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
class RemoteCoverFormatter extends FormatterBase {

  /**
   * Value of the ISBN without '-' char.
   *
   * @var string
   */
  protected $undashed_value;

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

    foreach ($items as $delta => $item) {
      if ($item->value) {
        // Part calling a theme function.
        $build[$delta] = array(
          '#theme' => 'happy_cover',
          '#cover_url' => new FormattableMarkup('http://covers.openlibrary.org/b/isbn/@undashed_isbn-L.jpg', ['@undashed_isbn' => $item->undashed_value]),
          '#cover_title' => $items->getEntity()->label(),
        );
      }
    }

    return $build;
  }

}
