<?php

namespace Drupal\rt_content_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactSettingsForm extends FormBase {

  public function getFormId() {
    return 'rt_content_entity_settings';
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['rt_contact_settings']['#markup'] = 'Settings form for ContentEntity. Manage field settings here.';
    return $form;
  }
}
