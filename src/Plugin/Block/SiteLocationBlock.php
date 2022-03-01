<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\site_location\Service\LocationCore;

/**
 * Show the location and current time in a block.
 *
 * @Block(
 *   id = "site_location_and_current_time",
 *   admin_label = @Translation("Site Location"),
 *   category = @Translation("Site Location")
 * )
 */
class SiteLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Location core service.
   * 
   * @var \Drupal\site_location\Service\LocationCore
   */
  protected $locationCore;

  /**
   * {@inheritdoc}
   */
  public function build() {

    $message = $this->t("Location is not set.");

    $build = [
      '#theme' => 'site_location_location_with_current_time',
      '#location' => $this->locationCore->getSiteLocation(),
      '#current_time' => $this->locationCore->getLocationCurrentTime(),
      '#message' => $message,
      '#cache' => [
        'tags' => $this->getCacheTags(),
      ],
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['config:site_location.settings']);
  }

  /**
   * @param ContainerInterface $container
   * @param array $configuration
   * @param type $plugin_id
   * @param type $plugin_definition
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_location.location_core')
    );
  }

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\site_location\Service\LocationCore $location_core
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LocationCore $location_core) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->locationCore = $location_core;
  }

}
