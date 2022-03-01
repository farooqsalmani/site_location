<?php

namespace Drupal\site_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Site Location settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * Getter method for Form Id.
   * 
   * @return string
   *   Returns the unique Id of the form defined by this class.
   */
  public function getFormId() {
    return 'site_location_settings';
  }

  /**
   * Get the configuration name to edit.
   * 
   * @return array
   *   Returns the configuration name for the module.
   */
  protected function getEditableConfigNames() {
    return ['site_location.settings'];
  }

  /**
   * Build Site Location settings form.
   * 
   * @param array $form
   *   The render array for current build form.
   * @param FormStateInterface $form_state
   *   Object describing the current state of the form.
   * 
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#default_value' => $this->config('site_location.settings')->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#default_value' => $this->config('site_location.settings')->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#required' => TRUE,
      '#options' => $this->getSiteTimezones(),
      '#default_value' => $this->config('site_location.settings')->get('timezone'),
    ];
    
    return parent::buildForm($form, $form_state);
  }

  /**
   * Validation handler for Site Location settings form.
   * 
   * @param array $form
   *   The render array for current build form.
   * @param FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state)   { 
    if (empty($form_state->getValue('country'))) {
      $form_state->setErrorByName('country', $this->t('Please enter the country name.'));
    }

    if (empty($form_state->getValue('city'))) {
      $form_state->setErrorByName('city', $this->t('Please enter the city name.'));
    }
    
    parent::validateForm($form, $form_state);
  }

  /**
   * Submit handler for Site Location settings form.
   * 
   * @param array $form
   *   The render array for current build form.
   * @param FormStateInterface $form_state
   *   Object describing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('site_location.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Get the site timezones.
   * 
   * @return array
   *   Returns the array of timezones for some specific sites.
   */
  private function getSiteTimezones() {
    return [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];
  }

}
