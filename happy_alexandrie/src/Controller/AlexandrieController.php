<?php

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityViewModeInterface;

class AlexandrieController extends ControllerBase {

  /**
   * /welcome route callback.
   *
   * @param string $name
   *   The name of the visitor to show.
   *
   * @return array
   *   The render array of the page.
   */
  public function helloWorld($name) {
    $build = [];

    $build['intro'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('Welcome @name into the Great Library', ['@name' => $name]),
    ];

    $config = $this->config('happy_alexandrie.library_config');
    $params = [
      '%opening' => $config->get('opening'),
      '%closing' => $config->get('closing'),
    ];
    $build['schedule'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('The library opens at %opening and closes at %closing.', $params),
    ];

    return $build;
  }

  /**
   * /books route callback.
   *
   * @param \Drupal\Core\Entity\EntityViewModeInterface $view_mode
   *   the view mode to use to render books.
   *
   * @return array The render array of the page.
   *   The render array of the page.
   */
  public function listBooks(EntityViewModeInterface $view_mode) {
    // Get all the published books nids.
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'alexandrie_book')
      ->condition('status', 1)
      ->sort('created', 'DESC');
    $nids = $query->execute();
    if (empty($nids)) {
      return [];
    }

    // Get the entity type manager service.
    $entity_type_manager = \Drupal::entityTypeManager();

    // Load the books nodes.
    $storage = $entity_type_manager->getStorage('node');
    $nodes = $storage->loadMultiple($nids);
    if (empty($nodes)) {
      return [];
    }

    // Extract the view mode name.
    $view_mode_name = explode('.', $view_mode->id())[1];

    // Prepare the books display render arrays.
    $view_builder = $entity_type_manager->getViewBuilder('node');
    return $view_builder->viewMultiple($nodes, $view_mode_name);
  }

}
