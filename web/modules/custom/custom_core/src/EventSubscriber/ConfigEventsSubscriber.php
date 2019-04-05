<?php

namespace Drupal\custom_core\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;




class ConfigEventsSubscriber implements EventSubscriberInterface {


  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => 'configSave',
      ConfigEvents::DELETE => 'configDelete'
    ];
  }

  /**
   * React to a config object being saved.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */

  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    drupal_set_message('Saved config: ' . $config->getName());
  }


  /**
   * React to a config object being deleted.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */

  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    drupal_set_message('Deleted config: ' . $config->getName());
  }
}
