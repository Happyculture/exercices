<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCoverFormatter.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\happy_alexandrie\Service\GetCoverServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
          '#cover_url' => \Drupal::service('happy_alexandrie.get_cover_service')->getCover($item->undashed_value),
          '#cover_title' => $items->getEntity()->label(),
        );
      }
    }

    return $build;
  }

}
