<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\happy_alexandrie\Service\GetCoverServiceInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\StringFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class RemoteCover extends StringFormatter { implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\happy_alexandrie\Service\GetCoverServiceInterface
   */
  protected $coverService;

  /**
   * Constructs a RemoteCover object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\happy_alexandrie\Service\GetCoverServiceInterface $cover_service
   *   The cover service.
   */
  public function __construct($plugin_id, $plugin_definition, \Drupal\Core\Field\FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, GetCoverServiceInterface $cover_service) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->coverService = $cover_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('happy_alexandrie.get_cover')
    );
  }

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

    foreach ($items as $delta => $item) {
      $prop_name = $item->mainPropertyName();
      $elements[$delta] = [
        '#theme' => 'remote_cover',
        '#url' => $this->coverService->getCover($item->{$prop_name}, $this->getSetting('cover_size')),
        '#title' => $items->getEntity()->label(),
      ];
    }

    return $elements;
  }

}
