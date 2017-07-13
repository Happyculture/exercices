<?php

namespace Drupal\happy_alexandrie\Form;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AlexandrieConfigForm extends ConfigFormBase {

  const DATE_FORMAT = 'H:i';

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
    $defaults = [
      '#type' => 'datetime',
      '#date_date_element' => 'none',
      '#date_time_element' => 'time',
      '#date_increment' => 60,
    ];
    $form['opening'] = $defaults + [
      '#title' => $this->t('Opening'),
      '#default_value' => DrupalDateTime::createFromFormat(self::DATE_FORMAT, $config->get('opening')),
    ];
    $form['closing'] = $defaults + [
      '#title' => $this->t('Closing'),
      '#default_value' => DrupalDateTime::createFromFormat(self::DATE_FORMAT, $config->get('closing')),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('happy_alexandrie.library_config')
      ->set('opening', $form_state->getValue('opening')->format(self::DATE_FORMAT))
      ->set('closing', $form_state->getValue('closing')->format(self::DATE_FORMAT))
      ->save();
  }

}
