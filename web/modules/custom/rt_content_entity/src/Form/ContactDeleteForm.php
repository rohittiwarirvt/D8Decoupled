<?php

namespace Drupal\rt_content_entity\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;


class ContactDeleteForm extends ContentEntityConfirmFormBase {

  public function getQuestion() {
    return $this->t('Are you sure you want  to delete entity %name?', ['%name' => $this->entity->label()]);

  }

  public function getCancelUrl() {
    return new Url('entity.rt_content_entity_contact.collection');
  }


  public function getConfirmText() {
    return $this->t('Delete');
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->delete();
    $this->logger('rt_content_entity')->notice('@type: delete %title', [
        '@type' => $this->entity->bundle(),
        '%title' => $this->entity->label(),
      ]);

    $form_state->setRedirect('entity.rt_content_entity_contact.collection');
  }
}
