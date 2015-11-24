<?php
/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\Field\FieldFormatter\RemoteCover.
 */

namespace Drupal\happy_alexandrie\Plugin\Field\FieldFormatter;

use Drupal\happy_alexandrie\RemoteCoverWSPluginManager;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'remote_cover' formatter.
 *
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
class RemoteCover extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The get cover service.
   *
   * @var \Drupal\happy_alexandrie\RemoteCoverWSPluginManager
   */
  protected $remote_cover_plugin_manager;

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
   * @param \Drupal\happy_alexandrie\RemoteCoverWSPluginManager $remote_cover_plugin_manager
   *   The remove cover service plugin manager.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, RemoteCoverWSPluginManager $remote_cover_plugin_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->remote_cover_plugin_manager = $remote_cover_plugin_manager;
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
      $container->get('plugin.manager.happy_alexandrie.remote_cover')
    );
  }

  public function getRemoteTypes() {
    $types = array();
    foreach ($this->remote_cover_plugin_manager->getDefinitions() as $id => $plugin_data) {
      $types[$id] = $plugin_data['name'];
    }
    return $types;
  }

  /**
   * {@inheritdoc}
   * Returns a form to configure settings for the formatter.
   * Similar to Drupal 7.
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['cover_source'] = array(
      '#type' => 'select',
      '#title' => t('Cover type'),
      '#options' => $this->getRemoteTypes(),
      '#default_value' => $this->getSetting('cover_source'),
    );
    return $element;
  }

  /**
   * Returns the summary of your field settings.
   * It's similar to Drupal 7.
   */
  public function settingsSummary() {
    $source = $this->getSetting('cover_source');
    $types = $this->getRemoteTypes();
    return array(t('Source for the cover: %source', array('%source' => $types[$source])));
  }

  /**
   * Defines the default settings, without this you can't create your entries
   * in the $this->getSettings('setting_name') callback.
   */
  public static function defaultSettings() {
    return array(
      'cover_source' => 'openlibrary_remote_cover',
    ) + parent::defaultSettings();
  }

  /**
   * This method is helpful in order to prepare the data for the output.
   * In our example we have an element code as entry data and are going to
   * get a full image URL from this code.
   * We fetch the image from a different place whether it's an image or a movie
   * that we want to display.
   */
  public function prepareView(array $entities_items) {
    $plugin_id = $this->getSetting('cover_source');
    $RemoteCoverWS = $this->remote_cover_plugin_manager->createInstance($plugin_id);
    foreach ($entities_items as $items) {
      foreach ($items as $item) {
        $name = $item->mainPropertyName();
        if ($item->get($name)->getValue()) {
          // Get the name of the main property of the field.
          $item->value = $RemoteCoverWS->getCover($item->get($name)->getValue());
        }
      }
    }
  }

  /**
   * This method is the wrapper for the formatter.
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {
    $elements = parent::view($items);
    $types = $this->getRemoteTypes();
    $elements['#prefix'] = '<p>The cover source is: ' . $types[$this->settings['cover_source']] . '</p>';
    return $elements;
  }

  /**
   * This method is the wrapper for each field value.
   */
  public function viewElements(FieldItemListInterface $items, $langcode = NULL) {
    $elements = array();
    foreach ($items as $delta => $item) {
      if ($item->value) {
        // Part calling a theme function.
        $elements[$delta] = array(
          '#theme' => 'happy_cover',
          '#cover_url' => $item->value,
          '#cover_title' => $items->getEntity()->label(),
        );
      }
    }
    return $elements;
  }
}
