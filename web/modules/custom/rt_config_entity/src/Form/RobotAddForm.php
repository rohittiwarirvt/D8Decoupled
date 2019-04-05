<?php

namespace Drupal\rt_config_entity\Form;

use Drupal\Core\Form\FormStateInterface;


class RobotAddForm extends RobotFormBase {

  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Create Robot');
    return $actions;
  }
}
