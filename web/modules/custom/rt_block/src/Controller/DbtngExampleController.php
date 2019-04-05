<?php

namespace Drupal\rt_block\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rt_block\Utility\DbtngExampleRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DbtngExampleController extends ControllerBase {

  protected $repository;


  public static function create(ContainerInterface $container) {
    $controller = new static($container->get('dbtng_example.repository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }


  public function __construct(DbtngExampleRepository $repository) {
    $this->repository= $repository;
  }


  public function entryList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('Generate a list of all entries in database. There is no filter in the query')
    ];

    $rows = [];

    $headers = [
      $this->t('Id'),
      $this->t('uid'),
      $this->t('Name'),
      $this->t('Surname'),
      $this->t('Age'),
    ];

    foreach ($entries = $this->repository->load() as $entry) {
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', (array) $entry);
    }

    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => $this->t('No entries available')
    ];

    // Don't cache this page
    //
    $content['#cache']['max-age'] =0;
    return $content;
  }

  public function entryAdvancedList() {

  }


}



