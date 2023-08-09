<?php

namespace Drupal\poke_collection\Plugin\Action;

use Drupal\Core\Action\ActionBase;

/**
 * Bulk delete action for pokecards.
 *
 * @Action(
 *   id = "bulk_delete_pokecard",
 *   label = @Translation("Remove selected Pokecards"),
 *   type = "pokecard"
 * )
 */
class BulkDelete extends ActionBase
{
  /**
   * {@inheritdoc}
   */
  public function execute(PokeCardInterface $pokecard)
  {
    if(isset($pokecard)) {
      try {
        $pokecard->delete();
      } catch(EntityStorageException $e) {
        \Drupal::logger('my_module')->error("Error while deleting pokecard: " . $e->getMessage());
      }
    }
  }
}
