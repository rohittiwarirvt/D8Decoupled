<?php


namespace Drupal\rt_config_entity;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;



class RobotAccessController extends EntityAccessControlHandler {

  public function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    if ( $operation == 'view') {
      return AccessResult::allowed();
    }

    return parent::checkAccess($entity, $operation, $account);
  }
}
