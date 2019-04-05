<?php

namespace  Drupal\rt_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;


/**
 * @ConfigEntityType(
 *   id = "robot",
 *   label = @Translation("Robot"),
 *   admin_permission = "administer robots",
 *   handlers = {
 *     "access" = "Drupal\rt_config_entity\RobotAccessController",
 *     "list_builder" = "Drupal\rt_config_entity\Controller\RobotListBuilder",
 *     "form" = {
 *       "add" = "Drupal\rt_config_entity\Form\RobotAddForm",
 *       "edit" = "Drupal\rt_config_entity\Form\RobotEditForm",
 *       "delete" = "Drupal\rt_config_entity\Form\RobotDeleteForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "edit-form" = "/rt_config_entity/manage/{robot}",
 *     "delete-form" = "/rt_config_entity/manage/{robot}/delete"
 *   }
 *
 *
 *
 * )
 */


class Robot extends ConfigEntityBase {

  public $id;

  public $uuid;

  public $label;

  public $floopy;
}
