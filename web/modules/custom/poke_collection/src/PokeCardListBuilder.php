<?php

namespace Drupal\poke_collection;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for pokecard entity.
 *
 * @ingroup poke_collection
 */
class PokeCardListBuilder extends EntityListBuilder
{

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the contact list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader()
  {
    $header['id'] = $this->t('Card Id');
    $header['name'] = $this->t('Name');
    $header['api_id'] = $this->t('Api ID');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /* @var $entity \Drupal\poke_collection\Entity\PokeCard */
    $row['id'] = $entity->id();
    $row['name'] = $entity->name()->value;
    $row['api_id'] = $entity->apiId()->value;
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render()
  {
    $build = parent::render();
    $build['table']['#empty'] = $this->t('No ' . $this->entityType->getPluralLabel() . ' added yet.');
    return $build;
  }

}
