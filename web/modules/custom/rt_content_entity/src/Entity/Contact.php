<?php

namespace Drupal\rt_content_entity\Entity;


use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\rt_content_entity\ContactInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;



/**
 * @ContentEntityType(
 *   id = "rt_content_entity_contact",
 *   label = @Translation("Contact entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rt_content_entity\Entity\Controller\ContactListBuilder",
 *     "form" = {
 *       "default" = "Drupal\rt_content_entity\Form\ContactForm",
 *       "delete" = "Drupal\rt_content_entity\Form\ContactDeleteForm"
 *     },
 *     "access" = "Drupal\rt_content_entity\ContactAccessControlHandler"
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "contact",
 *   admin_permission = "administer contact entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/rt_content_entity_contact/{rt_content_entity_contact}",
 *     "edit form" = "/rt_content_entity_contact/{rt_content_entity_contact}/edit",
 *     "delete form" = "/rt_content/{rt_content_entity_contact}/delete",
 *     "collection" = "/rt_content_entity_contact/list"
 *   },
 *   field_ui_base_route = "rt_content_entity.contact_settings",
 * )
 */


class Contact extends ContentEntityBase implements ContactInterface {
  use EntityChangedTrait;

  /**
   *  {@inheritdoc}
   */

  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }


  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * Define Field Properties here
   */

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Contact entity'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel('UUID')
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The Name of the contact entity'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0
      ])
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['first_name'] = BaseFieldDefinition::create('string')
        ->setLabel(t('First Name'))
        ->setDescription(t('The first name of the Contact entity'))
        ->setSettings([
          'max_length' => 255,
          'text_processing' => 0
        ])
        ->setDefaultValue(NULL)
        ->setDisplayOptions('view', [
          'label' => 'above',
          'type' => 'string',
          'weight' => -6,
        ])
        ->setDisplayOptions('form', [
          'type' => 'string_textfield',
          'weight' => -6,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

      $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('User Name'))
        ->setDescription(t('The Name of the associated user'))
        ->setSettings([
          'target_type' => 'user',
          'handler' => 'default'
        ])
        ->setDisplayOptions('view', [
          'label' => 'above',
          'type' => 'author',
          'weight' => -3
        ])
        ->setDisplayOptions('form', [
          'type' => 'entity_reference_autocomplete',
          'settings' => [
            'match_operator' => 'CONTAINS',
            'size' => 60,
            'placeholder' => '',
          ],
          'weight' => -3
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

        $fields['role'] = BaseFieldDefinition::create('list_string')
          ->setLabel(t('Role'))
          ->setDescription(t('The Role of the Contact entity'))
          ->setSettings([
            'allowed_values' => [
              'administrator' => 'administrator',
              'user' => 'user'
            ]
          ])
          ->setDefaultValue('user')
          ->setDisplayOptions('view', [
            'label' => 'above',
            'type' =>  'string',
            'weight' => -2
          ])
          ->setDisplayOptions('form', [
            'type' => 'options_select',
            'weight' => -2
          ])
          ->setDisplayConfigurable('form', TRUE)
          ->setDisplayConfigurable('view', TRUE);


        $fields['langcode'] = BaseFieldDefinition::create('language')
          ->setLabel('Language Code')
          ->setDescription(t('The language code of the ContentEntity entity'));

        $fields['created'] = BaseFieldDefinition::create('created')
          ->setLabel(t('Created'))
          ->setDescription(t('The time that the entity was created'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
          ->setLabel(t('Changed'))
          ->setDescription(t('The Time that the entity was last edited'));

        return $fields;
  }
}
