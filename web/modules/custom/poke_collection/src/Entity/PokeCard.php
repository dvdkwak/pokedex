<?php

namespace Drupal\poke_collection\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\poke_collection\PokeCardInterface;
use Drupal\Core\Field\FieldItemList;

/**
 * Defines the PokeCard entity.
 * The system collects all pokecards in a single database, while collection keep track of who has which card.
 *
 * @ContentEntityType(
 *   id = "pokecard",
 *   label = @Translation("PokeCard"),
 *   label_collection = @Translation("Pokecards"),
 *   label_singular = @Translation("Pokecard"),
 *   label_plural = @Translation("Pokecards"),
 *   base_table = "pokecard",
 *   translatable = FALSE,
 *   admin_permission = "administer pokecard",
 *   entity_keys = {
 *     "id" = "cid",
 *     "uuid" = "uuid"
 *   },
 *   handlers = {
 *     "list_builder" = "Drupal\poke_collection\PokeCardListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\poke_collection\Form\PokecardEntityForm",
 *       "edit" = "Drupal\poke_collection\Form\PokecardEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   links = {
 *     "add-form" = "/pokecard/add",
 *     "delete-form" = "/pokecard/{pokecard}/delete",
 *     "canonical" = "/pokecard/{pokecard}",
 *     "edit-form" = "/pokecard/{pokecard}/edit",
 *     "delete-multiple-form" = "/admin/content/pokecard/delete-multiple",
 *     "collection" = "/admin/content/pokecard"
 *   }
 * )
 */

class PokeCard extends ContentEntityBase implements ContentEntityInterface
{

  /**
   * The id of the pokecard (drupal id).
   *
   * @var string
   *  The drupal id of a pokecard.
   */
  protected $cid;

  /**
   * {@inheritdoc}
   */
  public function id()
  {
    return $this->cid;
  }

  /**
   * {@inheritdoc}
   */
  public function name(): FieldItemList
  {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function apiId(): FieldItemList
  {
    return $this->api_id;
  }


  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {
    parent::baseFieldDefinitions($entity_type);

    // Standard field, used as unique if primary index.
    $fields['cid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the pokemon card.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the pokemon card.'))
      ->setReadOnly(TRUE);

    // Name of the PokeCard, the name which can be viewed within the list of PokeCards.
    $fields['name'] = baseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the pokemon card.'));

    // Field to store the card id from the api.
    $fields['api_id'] = baseFieldDefinition::create('string')
      ->setLabel(t('Api card id'))
      ->setDescription(t('The ID given to the card within the pokemon tcg api.'));

    return $fields;
  }

}
