<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCoverFormatter.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\happy_alexandrie\Service\GetCoverServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @FieldFormatter(
 *   id = "remote_cover",
 *   label = @Translation("Remote cover"),
 *   field_types = {
 *     "string",
 *     "isbn"
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
 *   }
 * )
 */
class RemoteCoverFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The get cover service.
   *
   * @var \Drupal\happy_alexandrie\Service\GetCoverServiceInterface
   */
  protected $remote_cover_service;

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
   * @param \Drupal\happy_alexandrie\Service\GetCoverServiceInterface $remote_cover_service
   *   The remove cover service plugin manager.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, GetCoverServiceInterface $remote_cover_service) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->remote_cover_service = $remote_cover_service;
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
      $container->get('happy_alexandrie.get_cover_service')
    );
  }

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
          '#cover_url' => $this->remote_cover_service->getCover($item->undashed_value),
          '#cover_title' => $items->getEntity()->label(),
        );
      }
    }

    return $build;
  }

}
