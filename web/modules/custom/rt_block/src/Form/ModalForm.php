<?php

namespace Drupal\rt_block\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Url;
use Drupal\Component\Render\FormattableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;



class ModalForm extends FormBase {


  public static function create(ContainerInterface $container) {
    $form = new static();
    $form->setRequestStack($container->get('request_stack'));
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));

    return $form;
  }

  public function getFormId(){
    return 'form_api_example_modal_form';

  }


  protected static function getDataDialogOptions() {
    return [
      'width' => '50%',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state, $nojs = NULL) {
    $form['#attached']['library'][] = 'core/drupal.ajax';

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This example demonstrates a form that can work as a normal multi-request form, or as a modal dialog using AJAX.'),
    ];

    if ($nojs == 'nojs') {
      $form['use_ajax_container'] = [
        '#type' => 'details',
        '#open' => TRUE,
      ];
      $form['use_ajax_container']['description'] = [
        '#type' => 'item',
        '#markup' => $this->t('In order to show a modal dialog by clicking on a link, that link has to have class <code>use-ajax</code> and <code>data-dialog-type="modal"</code>. This link has those attributes.'),
      ];
      $form['use_ajax_container']['use_ajax'] = [
        '#type' => 'link',
        '#title' => $this->t('See this form as a model'),
        '#url' => Url::fromRoute('form_api_example.modal_form', ['nojs' => 'ajax']),
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => json_encode(static::getDataDialogOptions()),
          'id' => 'ajax-example-modal-link'
        ]

      ];
    }

    if ($nojs == 'ajax') {

      $form['status_messages'] = [
        '#type' => 'status_messages',
        '#weight' => -999,
      ];
    }

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#required' => TRUE,
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form.
    $form['actions'] = [
      '#type' => 'actions',
    ];


    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmitForm',
        'event' => 'click'
      ]
    ];


    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    $this->messenger()->addMessage(
      $this->t('Sumbit handles you specified title of @title', ['@title' => $title])
    );
  }

  public function ajaxSubmitForm(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    if ($form_state->getErrors()) {

    } else {
      $this->messenger()->deleteAll();

      $title = new FormattableMarkup(':title', [':title' => $form_state->getValue('title')]);

      $content = [
        '#type' => 'item',
        '#markup' => $this->t("YOur specified title '%title' appears in this modal dialog", ['%title' => $title])
      ];

      $response->addCommand(new OpenModalDialogCommand($title, $content, static::getDataDialogOptions()));
    }

    return $response;
  }
}
