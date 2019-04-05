<?php

namespace Drupal\rt_block\Controller;


use Drupal\rt_block\Utility\DescriptionTemplateTrait;


class BlockExampleController {
  use DescriptionTemplateTrait;


  protected function getModuleName() {
    return 'rt_block';
  }
}
