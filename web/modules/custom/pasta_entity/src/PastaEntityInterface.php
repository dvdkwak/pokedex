<?php declare(strict_types = 1);

namespace Drupal\pasta_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a pasta entity entity type.
 */
interface PastaEntityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
