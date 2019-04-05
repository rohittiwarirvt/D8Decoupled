<?php

namespace Drupal\rt_config_entity\Controller;


use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\rt_block\Utility\DescriptionTemplateTrait;

class  RobotListBuilder extends ConfigEntityListBuilder {


  use DescriptionTemplateTrait;



  protected function getDescriptionTemplatePath() {
    return drupal_get_path('module', $this->getModuleName()) . "/templates/description.html.twig";
  }


  protected function getModuleName() {
    return 'rt_config_entity';
  }


  public function buildHeader() {
    $header['label'] == $this->t('Robot');
    $header['machine_name'] = $this->t('Machine Name');
    $header['floopy'] = $this->t('Floopy');
    return $header + parent::buildHeader();
  }


  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['machine_name'] = $entity->id();
    $row['floopy'] = $entity->floopy;

    return $row + parent::buildRow($entity);
  }

  public function render() {
    $build = $this->description();
    $build[] = parent::render();
    return $build;
  }
}
