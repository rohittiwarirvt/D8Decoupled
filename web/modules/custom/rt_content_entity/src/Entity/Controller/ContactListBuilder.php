<?php

namespace Drupal\rt_content_entity\Entity\Controller;


use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ContactListBuilder extends EntityListBuilder {

  protected $urlGenerator;


  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage,
    UrlGeneratorInterface $url_generator
  ) {

    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Content Entity Examplesimplemets a contact model.
        These contacts are fieldable entityes. You can manage the fields on the <a href="@adminlink"> Contacts admin page</a>', ['@adminlink' => $this->urlGenerator->generateFromRoute('rt_content_entity.contact_settings')])

    ];

    $build['table'] = parent::render();

    return $build;
  }

  public function buildHeader() {
    $header['id'] = $this->t('ContactID');
    $header['name'] = $this->t('Name');
    $header['first_name'] = $this->t('First Name');
    $header['role'] = $this->t('Role');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->id();
    $row['name'] = $entity->link();
    $row['first_name'] = $entity->first_name->value;
    $row['role'] = $entity->role->value;
    return $row + parent::buildRow($entity);
  }
}
