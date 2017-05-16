<?php

namespace Drupal\d8training_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Footer' Block.
 *
 * @Block(
 *   id = "footer_block",
 *   admin_label = @Translation("Footer block"),
 * )
 */
class FooterBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('d8training_module.global_configuration');

    $data = array(
      '#footer' => 'footer',
      '#email' => $config->get('email'),
      '#telephone' => $config->get('telephone'),
    );

    return  $data;
  }
}
