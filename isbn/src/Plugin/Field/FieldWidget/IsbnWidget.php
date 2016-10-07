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
   * Form displayed when the field is edited.
   *
   * If the field cardinality is greater than one, this form is repeated as
   * many times as required.
   * You can see in this form, how to access to a widget setting.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $default_isbn_value = NULL;
    if (isset($items[$delta]->isbn_13)) {
      $default_isbn_value = $items[$delta]->isbn_13;
    }
    $element['isbn_13'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN-13'),
      '#default_value' => $default_isbn_value,
      '#required' => $element['#required'],
    );

    $element['isbn_10'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN-10'),
      '#default_value' => isset($items[$delta]->isbn_10) ? $items[$delta]->isbn_10 : NULL,
    );

    return $element;
  }
}
