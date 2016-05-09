<?php

/**
 * @file
 * Contains author_entity.page.inc.
 *
 * Page callback for Author entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Author templates.
 *
 * Default template: author_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_author_entity(array &$variables) {
  // Fetch AuthorEntity Entity Object.
  $author_entity = $variables['elements']['#author_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
