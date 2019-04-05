<?php


namespace Drupal\rt_block\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



class SimpleForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This basic example shows a single text input element and a submit button')
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Title must  be at least  5 characters in length'),
      '#required' => TRUE
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit')
    ];

    return $form;
  }


  public function getFormId() {
    return 'form_api_example_simple_form';
  }



  public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 3) {
      $form_state->setErrorByName('title', $this->t('The title must be atleast 5 characters long'));
    }
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    $this->messenger()->addMessage($this->t('You specified a title of %title.', ['%title' => $title]));
  }

}
