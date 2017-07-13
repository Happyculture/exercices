<?php

namespace Drupal\happy_alexandrie\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AlexandrieConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['happy_alexandrie.library_config'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'alexandrie_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('happy_alexandrie.library_config');
    $form['opening'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Opening'),
      '#default_value' => $config->get('opening'),
    ];
    $form['closing'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Closing'),
      '#default_value' => $config->get('closing'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('happy_alexandrie.library_config')
      ->set('opening', $form_state->getValue('opening'))
      ->set('closing', $form_state->getValue('closing'))
      ->save();
  }

}
