<?php

namespace Drupal\rt_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;



/**
 * @Block(
 *  id = "example_uppercase",
 *  admin_label = @Translation("Example: uppercase this please")
 * )
 */


class ExampleBlockUpperCase extends BlockBase {



  public function build() {

    return [
      '#markup' => $this->t("This block's title is changed to uppercase, Any block title which contains upppercase will also be changed to uppercase")
    ];
  }
}
