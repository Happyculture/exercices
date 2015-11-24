<?php

/**
 * @file
 * Contains \Drupal\happy_alexandrie\Plugin\RemoteCoverWS\Themoviedb.
 */

namespace Drupal\happy_alexandrie\Plugin\RemoteCoverWS;

use Drupal\happy_alexandrie\RemoteCoverWSPluginBase;
use GuzzleHttp\Client;
use Drupal\Core\Url;

/**
 * Fetch a cover from the movie db web service.
 *
 * @RemoteCoverWS(
 *   id = "themoviedb_remote_cover",
 *   name = "Movie (From IMDB)"
 * )
 */
class Themoviedb extends RemoteCoverWSPluginBase {


  /**
   * The base image url used to build the full url.
   *
   * @var string
   */
  protected $image_base_url;

  /**
   * Constructs a \Drupal\happy_alexandrie\Plugin\RemoteCoverWS\Themoviedb object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->base_webservice_url = 'http://api.themoviedb.org/3/';
  }

  /**
   * build the webservice url with parameter, ready to be called.
   *
   * @var string
   *   The parameter used by the service to get the url of a cover.
   */
  public function buildWebserviceUrl($param) {
    $options = array(
      'query' => array(
        'api_key' => '061b3cf0b719f619b541d132a0491dd0',
        'include_image_language' => 'fr,null',
      ),
      'absolute' => TRUE,
      //'https' => true,
    );
    $this->webservice_url_with_parameters = Url::fromUri($this->base_webservice_url . $param, $options);
  }

  /**
   * Call the web service with the good parameter to get the cover image url.
   *
   * @var string
   *   The parameter used by the service to get the url of a cover. An isbn
   *   number most of the time.
   *
   * @return string
   *   An url of the image cover.
   */
  public function getCover($param) {
    // Data from http://docs.themoviedb.apiary.io.
    // Get the updated config structure.
    $this->buildWebserviceUrl('configuration');
    try {
      $this->fetchResponse();
    } catch (\Exception $e) {
      // If an error occurred just reset the field value.
      return FALSE;
    };
    $this->image_base_url = $this->response['images']['base_url'] . '/w500/';

    // Get the movie details.
    $this->buildWebserviceUrl('movie/' . $param);
    try {
      $this->fetchResponse();
    } catch (\Exception $e) {
      // If an error occurred just reset the field value.
      return FALSE;
    };

    return $this->extractCover();
  }

  /**
   * Extract the cover image url from the response webservice data.
   *
   * @return string
   *   An url of the image cover.
   */
  protected function extractCover() {
    return $this->image_base_url . $this->response['poster_path'];
  }

  /**
   * Helper function to fetch a result from the webservice.
   */
  protected function fetchResponse() {
    $client = new Client();
    $response = $client->get($this->webservice_url_with_parameters);
    $this->response = $response->json();
  }
}
