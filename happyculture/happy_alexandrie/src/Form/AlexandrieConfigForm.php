<?php

namespace Drupal\happy_alexandrie\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for the grand Alexandrie library.
 */
class AlexandrieConfigForm extends ConfigFormBase {
  /**
   * Defines the form ID.
   *
   * This method replaces the hook_form.
   */
  public function getFormId() {
    return 'alexandrie_config_form';
  }

  /**
   * Indicates the namespace of the exported data for this form.
   *
   * Specific to the config forms, indicates under which name the configuration
   * data should be exported. It will be the filename of the exported data.
   */
  public function getEditableConfigNames() {
    return ['happy_alexandrie.library_config'];
  }

  /**
   * Defines the form structure.
   *
   * This is where you will define the content of the form, note that the
   * method takes two arguments as in Drupal 7, the form and form state but
   * the form states is now an object, it must match the FormStateInterface.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Call the parent implementation to inherit from the save button and
    // form style.
    $form = parent::buildForm($form, $form_state);

    // Add our custom form fields.
    $form['opening_hours'] = array(
      '#type' => 'textarea',
      '#title' => 'Opening hours',
      '#description' => 'Days / hours of the library',
      '#default_value' => $this->config('happy_alexandrie.library_config')->get('opening_hours'),
      '#rows' => 5,
    );
    return $form;
  }

  /**
   * Submit callback.
   *
   * Implements the form logic.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('happy_alexandrie.library_config')
      ->set('opening_hours', $form_state->getValue('opening_hours'))
      ->save();
    // Call the parent implementation to inherit from what has been done in it.
    // In our case, display the confirmation message.
    parent::submitForm($form, $form_state);
  }
}
