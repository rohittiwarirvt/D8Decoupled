<?php

namespace Drupal\rt_block\Form;


use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rt_block\Utility\DbtngExampleRepository;


class DbtngExampleAddForm implements FormInterface, ContainerInjectionInterface {


  use StringTranslationTrait;
  use MessengerTrait;


  protected $repository;

  protected $currentUser;

  public static function create(ContainerInterface $container) {
    $form = new static(
      $container->get('dbtng_example.repository'),
      $container->get('current_user')
    );

    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));

    return $form;
  }


  public function __construct(DbtngExampleRepository $repository, AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
    $this->repository = $repository;
  }


  public function getFormId() {
    return 'dbtng_example_add_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the dbtng_example table.'),
    ];

    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add a person entry'),
    ];
    $form['add']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#size' => 15,
    ];
    $form['add']['surname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Surname'),
      '#size' => 15,
    ];
    $form['add']['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#size' => 5,
      '#description' => $this->t("Values greater than 127 will cause an exception. Try it - it's a great example why exception handling is needed with DTBNG."),
    ];
    $form['add']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add'),
    ];

    return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    if ($this->currentUser->isAnonymous()) {
      $form_state->setError($form['add'], $this->t('You must be logged in to add values to the database'));
    }

    if (!intval($form_state->getValue('age'))) {
      $form_state->setErrorByName('age', $this->t('Age needs to be a number'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $account = $this->currentUser;

    $entry = [
      'name' => $form_state->getValue('name'),
      'age' => $form_state->getValue('age'),
      'surname' => $form_state->getValue('surname'),
      'uid' => $account->id()
    ];

    $return = $this->repository->insert($entry);

    if ($return) {
      $this->messenger()->addMessage($this->t('Created an entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
  }
}
