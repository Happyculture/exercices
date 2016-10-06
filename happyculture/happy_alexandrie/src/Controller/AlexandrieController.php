<?php

/**
 * @file
 * Contains Drupal\happy_alexandrie\Controller\AlexandrieController.
 */

namespace Drupal\happy_alexandrie\Controller;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityViewModeInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AlexandrieController extends ControllerBase {

  /**
   * The query factory to create entity queries.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  public $query_factory;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  public $entity_type_manager;

  public function __construct(QueryFactory $queryFactory, EntityTypeManager $entityTypeManager) {
    $this->query_factory = $queryFactory;
    $this->entity_type_manager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Say hello to the world.
   *
   * @return string
   *   Return "Hello world!" string.
   */
  public function helloWorld(EntityViewModeInterface $viewmode) {
    $content = [
      '#type' => 'markup',
      '#markup' => $this->t('Hello world bitch!')
    ];

    // Second version displaying the opening hours of the library.
    $opening_hours = $this->config('happy_alexandrie.library_config')->get('opening_hours');
    if (!empty($opening_hours)) {
      $content = [
        '#markup' => $this->t('<p>Greetings dear adventurer!</p><p>Opening hours:<br />@opening_hours</p>', array('@opening_hours' => $opening_hours)),
      ];
    }

    // Query against our entities.
    $query = $this->query_factory->get('node')
      ->condition('status', 1)
      ->condition('type', 'alexandrie_book')
      ->condition('changed', REQUEST_TIME, '<')
      ->range(0, 5);

    $nids = $query->execute();

    if ($nids) {
      // Load the storage manager of our entity.
      $storage = $this->entity_type_manager->getStorage('node');
      // Now we can load the entities.
      $nodes = $storage->loadMultiple($nids);

      list($entity_type, $viewmode_name) = explode('.', $viewmode->getOriginalId());
      // Get the EntityViewBuilder instance.
      $render_controller = $this->entity_type_manager->getViewBuilder('node');
      $build = $render_controller->viewMultiple($nodes, $viewmode_name);
      $build['#markup'] = $this->t('Happy Query by view mode: @label', array('@label' => $viewmode->label()));
      $content[] = $build;
    }
    else {
      $content[] = array(
        '#markup' => $this->t('No result')
      );
    }

    return $content;
  }
}
