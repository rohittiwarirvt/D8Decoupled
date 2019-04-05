<?php


namespace Drupal\custom_core\Event;


use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\Event;


class UserLoginEvent  extends Event {


  const EVENT_NAME = "custom_core_user_login";

  public $account;

  public function __construct(UserInterface $account) {
    $this->account = $account;
  }
}
