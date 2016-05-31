<?php

/**
 * @file
 * Contains \Drupal\user\Plugin\Block\LibraryBlock.
 */

namespace Drupal\happy_alexandrie\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResultAllowed;

/**
 * Provides a 'Call to visit' block.
 *
 * @Block(
 *   id = "visit_library",
 *   admin_label = @Translation("Visit the library"),
 * )
 */
class LibraryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $options = array(
      'attributes' => array(
        'title' => $this->configuration['link_title'],
      ),
    );
    return array(
      '#type' => 'link',
      '#title' => $this->configuration['link_title'],
      '#url' => new Url('happy_alexandrie.simple_welcome_controller', array(), $options),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    // Other ways to do it. Directly using the link element.
    return [
      Link::createFromRoute($this->configuration['link_title'], 'happy_alexandrie.query_welcome_controller')->toRenderable(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account, $return_as_object = FALSE) {
    return AccessResultAllowed::allowedIfHasPermission($account, 'access alexandrie library');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'link_title' => $this->t('Visit the library'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['link_label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label of the link'),
      '#maxlength' => 255,
      '#default_value' => $this->configuration['link_title'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('link_label', $form_state->getValue('link_label'));
  }
}