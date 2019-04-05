<?php


namespace Drupal\rt_block\Utility;


trait DescriptionTemplateTrait {

  public  function description() {
    $template_path = $this->getDescriptionTemplatePath();
    $template = file_get_contents($template_path);
    $build = [
      'description' => [
        '#type' => 'inline_template',
        '#template' => $template,
        '#context' => $this->getDescriptionVariables()
      ]
    ];
    return $build;
  }


  abstract protected function getModuleName();


  protected function getDescriptionVariables() {
    $variables = [
      'module' => $this->getModuleName()
    ];

    return $variables;
  }


  protected function getDescriptionTemplatePath() {
    return drupal_get_path('module', $this->getModuleName()) . "/templates/description.html.twig";
  }

}
