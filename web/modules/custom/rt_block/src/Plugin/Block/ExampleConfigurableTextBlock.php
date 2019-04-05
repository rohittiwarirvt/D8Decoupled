<?php


namespace Drupal\rt_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;




/**
 * @Block(
 *  id = "example_configurable_text",
 *  admin_label = @Translation("Example: configurable text")
 * )
 */


class ExampleConfigurableTextBlock extends BlockBase {


  public function defaultConfiguration() {
    return [
      'block_example_string' => $this->t('A default value. This block was created at %time', ['%time' => date('c')])
    ];
  }

  public function blockForm($form, FormStateInterface $form_state) {

    $form['block_example_string_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Block contents'),
      '#description' => $this->t('This text will appear in the example block'),
      '#default_value' => $this->configuration['block_example_string']
    ];
    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['block_example_string'] = $form_state->getValue('block_example_string_text');
  }

  public function build() {
    return [
      '#markup' => $this->configuration['block_example_string'],
    ];
  }
}
