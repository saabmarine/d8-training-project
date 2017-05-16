<?php
/**
 * @file
 * Contains \Drupal\d8training_module\Form\GlobalSettingsForm.
 */
namespace Drupal\d8training_module\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
/**
 * Configures site information for this site.
 */
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
      ]
    ];
    // $form['header_details'] = [
    //   '#type' => 'details',
    //   '#title' => t('Header details'),
    //   '#open' => TRUE,
    //   'primary_logo' => [
    //     '#type' => 'managed_file',
    //     '#title' => t('Primary Logo'),
    //     '#upload_validators' => [
    //       'file_validate_is_image' => [],
    //       'file_validate_extensions' => ['gif png jpg jpeg'],
    //     ],
    //     '#upload_location' => 'public://primary-logo',
    //     '#default_value' => [$config->get('primary_logo')],
    //   ],
    //   'secondary_logo' => [
    //     '#type' => 'managed_file',
    //     '#title' => t('Secondary Logo'),
    //     '#upload_validators' => [
    //       'file_validate_is_image' => [],
    //       'file_validate_extensions' => ['gif png jpg jpeg'],
    //     ],
    //     '#upload_location' => 'public://secondary-logo',
    //     '#default_value' => [$config->get('secondary_logo')],
    //   ],
    //   'cta' => [
    //     '#type' => 'link',
    //     '#title' => $this->t('CTA'),
    //   ],
    // ];
    // $form['footer_details'] = [
    //   '#type' => 'details',
    //   '#title' => t('Footer details'),
    //   '#open' => TRUE,
    //   'footer_logo' => [
    //     '#type' => 'managed_file',
    //     '#title' => t('Footer Logo'),
    //     '#upload_validators' => [
    //       'file_validate_is_image' => [],
    //       'file_validate_extensions' => ['gif png jpg jpeg'],
    //     ],
    //     '#upload_location' => 'public://footer-logo',
    //     '#default_value' => [$config->get('footer_logo')],
    //   ],
    //   'copyright' => [
    //     '#type' => 'text_format',
    //     '#title' => $this->t('Copyright'),
    //     '#default_value' => $config->get('copyright'),
    //   ]
    // ];
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('d8training_module.global_configuration')
      ->set('email', $form_state->getValue('email'))
      ->set('telephone', $form_state->getValue('telephone'))
    //   ->set('address', $form_state->getValue('address'))
    //   ->set('primary_logo', reset($form_state->getValue('primary_logo')))
    //   ->set('secondary_logo', reset($form_state->getValue('secondary_logo')))
    //   ->set('cta', $form_state->getValue('cta'))
    //   ->set('footer_logo', reset($form_state->getValue('footer_logo')))
    //   ->set('copyright', strip_tags($form_state->getValue('copyright')['value'], '<span><a>'))
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
