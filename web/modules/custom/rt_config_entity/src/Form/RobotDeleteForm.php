<?php

namespace Drupal\rt_config_entity\Form;


use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;



class RobotDeleteForm extends EntityConfirmFormBase {

  public function getQuestion() {
    return $this->t('Are you sure you want to delet the robot %label?', [
      '%label' => $this->entity->label()
    ]);
  }


  public function getCofirmText() {
    return $this->t('Delete Robot');
  }


  public function getCancelUrl() {
    return new Url('entity.robot.list');
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();

    $this->messenger()->addMessage($this->t('Robot %label was deleted', ['%label' => $this->entity->label()]));

    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
