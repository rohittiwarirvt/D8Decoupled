<?php

namespace Drupal\rt_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
* @Block(
*   id= "example_empty",
*   admin_label= @Translation("Example: empty block")
)
**/

class ExampleEmptyBlock extends BlockBase {

  public function build() {
    return [];
  }
}
