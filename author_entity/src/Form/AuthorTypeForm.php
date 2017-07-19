<?php

namespace Drupal\author_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AuthorTypeForm.
 */
class AuthorTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $author_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $author_type->label(),
      '#description' => $this->t("Label for the Author type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $author_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\author_entity\Entity\AuthorType::load',
      ],
      '#disabled' => !$author_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $author_type = $this->entity;
    $status = $author_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Author type.', [
          '%label' => $author_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Author type.', [
          '%label' => $author_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($author_type->toUrl('collection'));
  }

}
