<?php

namespace Drupal\rt_content_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;


interface ContactInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
