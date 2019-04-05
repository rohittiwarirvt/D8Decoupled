<?php


namespace Drupal\rt_content_entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;



class ContactAccessControlHandler extends EntityAccessControlHandler {

  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    $admin_permission = $this->entityType->getAdminPermission();
    if ( \Drupal::currentUser()->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view contact entity');
        # code...
      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit contact entity');
        # code...
      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete contact entity');
        # code...

    }
    return AccessResult::neutral();
  }


  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundler = NULL) {
    $admin_permission =  $this->entityType->getAdminPermission();

    if (\Drupal::currentUser()->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }

    return AccessResult::allowedIfHasPermission($account, 'add contact entity');
  }
}
