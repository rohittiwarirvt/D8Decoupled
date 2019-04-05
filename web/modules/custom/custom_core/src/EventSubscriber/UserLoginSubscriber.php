<?php

namespace Drupal\custom_core\EventSubscriber;

use Drupal\custom_core\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserLoginSubscriber implements EventSubscriberInterface {

  protected $database;

  protected $dateFormatter;

  public static function getSubscribedEvents() {
    return [
      UserLoginEvent::EVENT_NAME => 'onUserLogin'
    ];
  }


  public function onUserLogin() {
    $database = \Drupal::database();
    $dateFormatter = \Drupal::service('date.formatter');

    $account_created = $database->select('users_field_data', 'ud')
      ->fields('ud', ['created'])
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    drupal_set_message(t('Welcome, your account was createdon %created_date.', [
      '%created_date' => $dateFormatter->format($account_created, 'short')
    ]));
  }
}
