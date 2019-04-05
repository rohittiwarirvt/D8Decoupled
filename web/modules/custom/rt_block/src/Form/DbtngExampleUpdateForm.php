<?php

namespace Drupal\rt_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\rt_block\Utility\DbtngExampleRepository;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DbtngExampleUpdateForm  extends FormBase {


  protected $repository;

  public function getFormId() {
    return 'dbtng_update_form';
  }

  public static function create(ContainerInterface $container) {
    $form = new static($container->get('dbtng_example.repository'));
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }


  public function __construct(DbtngExampleRepository $repository) {
    $this->repository = $repository;
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = [
      '#prefix' => '<div id="updateform">',
      '#suffix' => '</div>',
    ];

    $form['message'] = [
      '#markup' => $this->t('Demonstrate a database update operation.')
    ];

    $entries = $this->repository->load();

    if (empty($entries)) {
      $form['no_values'] = [
        '#value' => $this->t('No data bro')
      ];
    }

    $keyed_entries = [];

    foreach ($entries as $entry) {
      $options[$entry->pid] = $this->t('@pid: @name @surname (@age)', [
        '@pid' => $entry->pid,
        '@name' => $entry->name,
        '@surname' => $entry->surname,
        '@age' => $entry->age,
      ]);
      $keyed_entries[$entry->pid] = $entry;
    }

    $pid = $form_state->getValue('pid');

    $default_entry = !empty($pid) ? $keyed_entries[$pid] : $entries[0];

    $form_state->setValue('entries', $keyed_entries);

    $form['pid'] =  [
      '#type' => 'select',
      '#options' => $optoins,
      '#title' => $this->t('Choose entry to update'),
      '#default_value' => $default_entry->pid,
      '#ajax' => [
        'wrapper' => 'updateform',
        'callback' => [$this, 'updateCallback']
      ],
    ];

    $form['pid'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('Choose entry to update'),
      '#default_value' => $default_entry->pid,
      '#ajax' => [
        'wrapper' => 'updateform',
        'callback' => [$this, 'updateCallback'],
      ],
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated first name'),
      '#size' => 15,
      '#default_value' => $default_entry->name,
    ];

    $form['surname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated last name'),
      '#size' => 15,
      '#default_value' => $default_entry->surname,
    ];
    $form['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated age'),
      '#size' => 4,
      '#default_value' => $default_entry->age,
      '#description' => $this->t('Values greater than 127 will cause an exception'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
    ];
    return $form;
  }


  public function updateCallback(array $form, FormStateInterface $form_state) {
    $entries = $form_state->getValue('entries');
    $entry = $entries[$form_state->getValue('pid')];

    foreach (['name', 'surname', 'age'] as $item) {
      $form[$item]['#value'] = $entry->$item;
    }

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!intval($form_state->getValue('age'))) {
      $form_state->setErrorByName('age', $this->t('Age needs to be number'));
    }
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $account = $this->currentUser();

    $entry = [
      'pid' => $form_state->getValue('pid'),
      'name' => $form_state->getValue('name'),
      'surname' => $form_state->getValue('surname'),
      'age' => $form_state->getValue('age'),
      'uid' => $account->id(),
    ];
    $count = $this->repository->update($entry);
    $this->messenger()->addMessage($this->t('Updated entry @entry (@count row updated)', [
      '@count' => $count,
      '@entry' => print_r($entry, TRUE),
    ]));
  }

}
