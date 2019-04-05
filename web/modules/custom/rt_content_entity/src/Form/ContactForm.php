<?php

namespace Drupal\rt_content_entity\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;



class ContactForm extends ContentEntityForm {

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    $form['langcode'] = [
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->getUntranslated()->language()->getId(),
      '#language' => Language::STATE_ALL,
    ];

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.rt_content_entity_contact.collection');
    $entity = $this->getEntity();
    $entity->save();
  }
}
