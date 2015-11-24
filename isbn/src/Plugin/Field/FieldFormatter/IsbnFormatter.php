<?php

/**
 * @file
 * Contains \Drupal\isbn\Plugin\field\formatter\IsbnFormatter.
 */

namespace Drupal\isbn\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'isbn' formatter.
 *
 * @FieldFormatter(
 *   id = "isbn",
 *   label = @Translation("Isbn"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class IsbnFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'separated_display' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['separated_display'] = array(
      '#type' => 'checkbox',
      '#title' => t('Display ISBN number with hyphen separator.'),
      '#return_value' => '-',
      '#default_value' => $this->getSetting('separated_display'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $settings = $this->getSettings();

    if (!empty($settings['separated_display'])) {
      $summary[] = t('ISBN will be display with group separated with hyphen');
    }
    else {
      $summary[] = t('ISBN will be display with no separator');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode = NULL) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $name = $item->mainPropertyName();
      $elements[$delta] = array(
        '#markup' => $item->get($name)->getValue(),
      );
    }

    return $elements;
  }

}
