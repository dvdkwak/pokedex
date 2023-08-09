<?php

namespace Drupal\poke_collection;

use Drupal\Core\Entity\ContentEntityInterface;

interface PokeCardInterface extends ContentEntityInterface
{

  /**
   * Return the name of the pokemon card.
   *
   * @var string
   *  Name of the pokemon card.
   */
  public function name();


  /**
   * Returns the id of the card from the api.
   *
   * @var string
   *  ID of the card in the api.
   */
  public function cardId();

}
