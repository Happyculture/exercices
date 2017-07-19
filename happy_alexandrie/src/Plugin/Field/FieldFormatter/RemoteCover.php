<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\happy_alexandrie\Service\GetCoverServiceInterface;
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
  public static function defaultSettings() {
    return [
      'cover_size' => 'L',
    ] + parent::defaultSettings();
  }

  protected function getSizes() {
    return [
      'S' => $this->t('Small'),
      'M' => $this->t('Medium'),
      'L' => $this->t('Large'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['cover_size'] = [
      '#type' => 'select',
      '#title' => t('Cover size'),
      '#description' => t('Open library source file size.'),
      '#default_value' => $this->getSetting('cover_size'),
      '#options' => $this->getSizes(),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $sizes = $this->getSizes();
    $size = $this->getSetting('cover_size');
    $summary[] = t('Size: @size', ['@size' => $sizes[$size]]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    /** @var GetCoverServiceInterface $cover_service */
    $cover_service = \Drupal::service('happy_alexandrie.get_cover');

    foreach ($items as $delta => $item) {
      $prop_name = $item->mainPropertyName();
      $elements[$delta] = [
        '#theme' => 'remote_cover',
        '#url' => $cover_service->getCover($item->{$prop_name}, $this->getSetting('cover_size')),
        '#title' => $items->getEntity()->label(),
      ];
    }

    return $elements;
  }

}
