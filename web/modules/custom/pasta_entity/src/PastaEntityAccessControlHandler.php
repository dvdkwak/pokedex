<?php declare(strict_types = 1);

namespace Drupal\pasta_entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the pasta entity entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class PastaEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    return match($operation) {
      'view' => AccessResult::allowedIfHasPermissions($account, ['view pasta_entity', 'administer pasta_entity'], 'OR'),
      'update' => AccessResult::allowedIfHasPermissions($account, ['edit pasta_entity', 'administer pasta_entity'], 'OR'),
      'delete' => AccessResult::allowedIfHasPermissions($account, ['delete pasta_entity', 'administer pasta_entity'], 'OR'),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create pasta_entity', 'administer pasta_entity'], 'OR');
  }

}
