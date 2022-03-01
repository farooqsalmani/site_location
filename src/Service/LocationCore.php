<?php

namespace Drupal\site_location\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use DateTime;
use DateTimeZone;

/**
 * Service enabling use of Site Location related functions.
 */
class LocationCore {
  
  /**
   * Drupal config factory service.
   * 
   * @var \Drupal\Core\Config\ConfiFactoryInterface
   */
  protected $configFactory;
  
  /**
   * LocationCore constructor.
   * 
   * @param Drupal\Core\Config\ConfiFactoryInterface $config_factory
   *   Drupal config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory->get('site_location.settings');
  }
  
  /**
   * Get the location of the site. 
   * 
   * @return string
   *   Returns the location of the site.
   */
  public function getSiteLocation() {
    $location = '';
    if (!empty($this->configFactory->get('city'))) {
      $location .= $this->configFactory->get('city');
    }
    
    if (!empty($this->configFactory->get('country'))) {
      $location .= ', ' . $this->configFactory->get('country');
    }
    
    return $location;
  }

  /**
   * Get the time zone based on location. 
   * 
   * @return string
   *   Returns the formatted date time.
   */
  public function getLocationCurrentTime() {
    if ($this->configFactory->get('timezone')) {
      $date = new DateTime("now", new DateTimeZone($this->configFactory->get('timezone')));
      return $date->format('jS M Y - g:i A');
    }
    else {
      return '';
    }
  }

}
