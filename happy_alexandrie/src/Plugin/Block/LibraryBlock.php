<?php

namespace Drupal\happy_alexandrie\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
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
      '#title' => $this->configuration['link_title'],
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'link_title' => 'Visit the library',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['link_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link title'),
      '#default_value' => $this->configuration['link_title'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('link_title', $form_state->getValue('link_title'));
  }

}
