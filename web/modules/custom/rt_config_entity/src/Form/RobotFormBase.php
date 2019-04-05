<?php

namespace Drupal\rt_config_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RobotFormBase extends EntityForm {

  protected $entityStorage;


  public function __construct( EntityStorageInterface $entity_storage) {
    $this->entityStorage = $entity_storage;
  }


  public static function create(ContainerInterface $container) {
    $form = new static($container->get('entity_type.manager')->getStorage('robot'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }



  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $robot = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('label'),
      '#maxlength' => 255,
      '#default_value' => $robot->label(),
      '#required' => TRUE
    ];


    $form['id'] = [
      '#type' => 'machine_name',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $robot->id(),
      '#machine_name' => [
        'exists' => [$this, 'exists'],
        'replace_pattern' => '([^a-z0-9_]+)|(^custom$)',
        'error' => 'The machine readable name must me unique, and can only contain lowercase letters, numbers and underscores. Additionally, it can be results work "custom".',
      ],
      '#disabled' => !$robot->isNew(),
    ];

    $form['floopy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Floopy'),
      '#default_value' => $robot->floopy,
    ];

    return $form;
  }

  public function exists($entity_id, array $element, FormStateInterface $form_state) {
    $query = $this->entityStorage->getQuery();

    $result = $query->condition('id', $element['#field_prefix'] . $entity_id)
              ->execute();

    return (bool) $result;
  }


  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Save');
    return $actions;
  }

  public function validate(array $form, FormStateInterface $form_state) {
    parent::validate($form, $form_state);
  }


  public function save(array $form, FormStateInterface $form_state) {
    $robot = $this->getEntity();


    $status = $robot->save();

    $url = $robot->urlInfo();

    $edit_link = Link::fromTextAndUrl($this->t('Edit'), $url)->toString();

    if ($status == SAVED_UPDATED ) {
      $this->messenger()->addMessage($this->t('Robot %label has been updated.', ['%label' => $robot->label()]));
      $this->logger('contact')->notice('Robot %label has been updated.', ['%label' => $robot->label(), 'link' => $edit_link]);
    } else {

      $this->messenger()->addMessage($this->t('Robot %lable has been added', ['%label' => $robot->label()]));
      $this->logger('contact')->notice('Robot %label has been added.', ['%label' => $robot->label(), 'link' => $edit_link]);
    }

        // Redirect the user back to the listing route after the save operation.
    $form_state->setRedirect('entity.robot.list');
  }
}
