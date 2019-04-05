<?php

namespace Drupal\custom_core\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AnotherConfigEventsSubscriber implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => ['configSave', 100],
      ConfigEvents::DELETE => ['configDelete', -100]
    ];
  }

  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    drupal_set_message('(Another) Save config: ' . $config->getName());
  }

  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    drupal_set_message('(Another) Delete config: ' . $config->getName());
  }


}

