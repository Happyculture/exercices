<?php

namespace Drupal\happy_alexandrie\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'entity_reference_autocomplete' widget.
 *
 * @FieldWidget(
 *   id = "author_role_widget",
 *   label = @Translation("Author & role"),
 *   description = @Translation("An enriched autocomplete text field."),
 *   field_types = {
 *     "author_role"
 *   }
 * )
 */
class AuthorRoleWidget extends EntityReferenceAutocompleteWidget {

  /**
   * Widget inherited from the parent and enriched with our custom field.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // Get the parent elements.
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    // Expose our role attribute.
    $element['role'] = [
      '#type' => 'select',
      '#title' => 'Rôle',
      '#options' => ['Auteur', 'Co-auteur', 'Scénariste', 'Metteur en scène'],
      '#default_value' => $items[$delta]->get('role')->getValue(),
      '#weight' => 10
    ];
    return $element;
  }
}
