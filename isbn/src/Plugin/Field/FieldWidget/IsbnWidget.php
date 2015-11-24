<?php

/**
 * @file
 * Contains \Drupal\isbn\Plugin\Field\FieldWidget\IsbnWidget.
 */

namespace Drupal\isbn\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Plugin implementation of the 'isbn' widget.
 *
 * @FieldWidget(
 *   id = "isbn_default",
 *   label = @Translation("ISBN"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class IsbnWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'placeholder_isbn_10' => '',
      'placeholder_isbn_13' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['placeholder_isbn_13'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for ISBN 13'),
      '#default_value' => $this->getSetting('placeholder_isbn_13'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );
    $elements['placeholder_isbn_10'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for ISBN 10'),
      '#default_value' => $this->getSetting('placeholder_isbn_10'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $default_isbn_value = NULL;
    if (isset($items[$delta]->isbn_13)) {
      $default_isbn_value = $items[$delta]->isbn_13;
    }
    $element['isbn_13'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN-13'),
      '#placeholder' => $this->getSetting('placeholder_isbn_13'),
      '#default_value' => $default_isbn_value,
      '#required' => $element['#required'],
    );

    $element['isbn_10'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN-10'),
      '#placeholder' => $this->getSetting('placeholder_isbn_10'),
      '#default_value' => isset($items[$delta]->isbn_10) ? $items[$delta]->isbn_10 : NULL,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $error, array $form, FormStateInterface $form_state) {
    return $element[$error->arrayPropertyPath[0]];
  }


}
