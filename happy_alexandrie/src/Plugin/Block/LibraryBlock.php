<?php

namespace Drupal\happy_alexandrie\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'LibraryBlock' block.
 *
 * @Block(
 *  id = "library_block",
 *  admin_label = @Translation("Library block"),
 * )
 */
class LibraryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $build['link'] = [
      '#type' => 'link',
      '#url' => Url::fromRoute('happy_alexandrie.alexandrie_controller_welcome'),
      '#title' => $this->t('Visit the library'),
    ];

    return $build;
  }

}
