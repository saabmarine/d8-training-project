<?php

namespace Drupal\d8training_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Header' Block.
 *
 * @Block(
 *   id = "header_block",
 *   admin_label = @Translation("Header block"),
 * )
 */
class HeaderBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('d8training_module.global_configuration');

    $data = array(
      '#email' => $config->get('email'),
      '#telephone' => $config->get('telephone'),
    );
    
    return  $data;
  }
}
