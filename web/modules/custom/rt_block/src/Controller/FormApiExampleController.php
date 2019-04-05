<?php

namespace Drupal\rt_block\Controller;

use Drupal\rt_block\Utility\DescriptionTemplateTrait;




class FormApiExampleController {

  use DescriptionTemplateTrait;

  public function getModuleName() {
    return 'rt_block';
  }

  protected function getDescriptionTemplatePath() {
    return drupal_get_path('module', $this->getModuleName()) . "/templates/formapidescription.html.twig";
  }
}
