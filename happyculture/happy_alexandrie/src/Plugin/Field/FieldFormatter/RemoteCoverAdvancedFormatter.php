<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCoverFormatter.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCoverFormatter;

/**
 * @FieldFormatter(
 *   id = "remote_cover_advanced",
 *   label = @Translation("Remote cover (Advanced)"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class RemoteCoverAdvancedFormatter extends RemoteCoverFormatter {

  /**
   * Never forget to set the default setting value in case your user forgot to
   * fill a value.
   * It's also used for the configuration exportable API.
   */
  public static function defaultSettings() {
    return array(
      'cover_size' => 'M',
    ) + parent::defaultSettings();
  }

  /**
   * Configuration form to collect the settings values.
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = array();
    $sizes = ['S', 'M', 'L'];
    $element['cover_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Cover size'),
      '#description' => $this->t('Select the cover size to use.'),
      '#default_value' => $this->getSetting('cover_size'),
      '#options' => array_combine($sizes, $sizes),
    ];
    return $element;
  }

  /**
   * Summary of the settings values. Displayed before the settings form.
   */
  public function settingsSummary() {
    $view_mode = $this->getSetting('cover_size');
    $summary = [$this->t('Cover size: @size', ['@size' => $view_mode])];
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $build = [];

    foreach ($items as $item) {
      $cover = 'http://covers.openlibrary.org/b/isbn/' . $item->undashed_value . '-' . $this->getSetting('cover_size') . '.jpg';
      $build[] = [
        '#theme' => 'image',
        '#uri' => $cover,
      ];
    }

    return $build;
  }
}
