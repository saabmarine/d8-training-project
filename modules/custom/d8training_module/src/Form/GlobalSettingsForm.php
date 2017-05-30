<?php
/**
 * @file
 * Contains \Drupal\d8training_module\Form\GlobalSettingsForm.
 */
namespace Drupal\d8training_module\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class GlobalSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'd8training_global_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('d8training_module.global_configuration');
    $form['contact_details'] = [
      '#type' => 'details',
      '#title' => t('Contact details'),
      '#open' => TRUE,
      'email' => [
        '#type' => 'email',
        '#title' => $this->t('Email'),
        '#default_value' => $config->get('email'),
      ],
      'telephone' => [
        '#type' => 'tel',
        '#title' => $this->t('Telephone'),
        '#default_value' => $config->get('telephone'),
      ],
      'address' => [
        '#type' => 'textfield',
        '#title' => $this->t('Address'),
        '#default_value' => $config->get('address'),
      ]
    ];
    $form['social_links'] = [
      '#type' => 'details',
      '#title' => t('Social Links'),
      '#open' => TRUE,
      'facebook' => [
        '#type' => 'textfield',
        '#title' => $this->t('Facebook'),
        '#default_value' => $config->get('facebook'),
      ],
      'twitter' => [
        '#type' => 'textfield',
        '#title' => $this->t('Twitter'),
        '#default_value' => $config->get('twitter'),
      ],
      'behance' => [
        '#type' => 'textfield',
        '#title' => $this->t('Behance'),
        '#default_value' => $config->get('behance'),
      ],
      'instagram' => [
        '#type' => 'textfield',
        '#title' => $this->t('Instagram'),
        '#default_value' => $config->get('instagram'),
      ],
      'dribble' => [
        '#type' => 'textfield',
        '#title' => $this->t('Dribble'),
        '#default_value' => $config->get('dribble'),
      ],
      'skype' => [
        '#type' => 'textfield',
        '#title' => $this->t('Skype'),
        '#default_value' => $config->get('skype'),
      ],
      'google' => [
        '#type' => 'textfield',
        '#title' => $this->t('Google +'),
        '#default_value' => $config->get('google'),
      ],
    ];
    $form['logos'] = [
      '#type' => 'details',
      '#title' => t('Logos'),
      '#open' => TRUE,
      'primary_logo' => [
        '#type' => 'managed_file',
        '#title' => t('Primary Logo'),
        '#upload_validators' => [
          'file_validate_is_image' => [],
          'file_validate_extensions' => ['gif png jpg jpeg'],
        ],
        '#upload_location' => 'public://primary-logo',
        '#default_value' => [$config->get('primary_logo')],
        // '#required' => TRUE,
      ],
      'secondary_logo' => [
        '#type' => 'managed_file',
        '#title' => t('Secondary Logo'),
        '#upload_validators' => [
          'file_validate_is_image' => [],
          'file_validate_extensions' => ['gif png jpg jpeg'],
        ],
        '#upload_location' => 'public://secondary-logo',
        '#default_value' => [$config->get('secondary_logo')],
        // '#required' => TRUE,
      ],
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach(['primary_logo', 'secondary_logo'] as $field) {
      $image = $form_state->getValue($field);
      if (!empty($image)) {
        $file = File::load(current($image));
        $file->setPermanent();
        $file->save();
      }
    }

    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('d8training_module.global_configuration')
      ->set('email', $form_state->getValue('email'))
      ->set('telephone', $form_state->getValue('telephone'))
      ->set('address', $form_state->getValue('address'))
      ->set('facebook', $form_state->getValue('facebook'))
      ->set('twitter', $form_state->getValue('twitter'))
      ->set('behance', $form_state->getValue('behance'))
      ->set('instagram', $form_state->getValue('instagram'))
      ->set('dribble', $form_state->getValue('dribble'))
      ->set('skype', $form_state->getValue('skype'))
      ->set('google', $form_state->getValue('google'))
      ->set('primary_logo', reset($form_state->getValue('primary_logo')))
      ->set('secondary_logo', reset($form_state->getValue('secondary_logo')))
      ->save();
    parent::submitForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'd8training_module.global_configuration',
    ];
  }
}
