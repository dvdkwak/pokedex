<?php

namespace Drupal\pokedex\Controller;

use Drupal\Core\Controller\ControllerBase;
use InvalidArgumentException;

use Pokemon\Pokemon;

/**
 * Provides route responses for the Example module.
 */
class PokedexController extends ControllerBase
{

  /**
   * Returns a page which shows all cards of set, with paginator.
   *
   * @return array
   *   A simple renderable array.
   */
  public function Gallery(): array
  {
    // Getting pokedex config object.
    $config = \Drupal::config('pokedex.settings');

    // Search form.
    $form = \Drupal::formBuilder()->getForm('Drupal\pokedex\Form\PokedexFilter');

    // Retrieving uri params if available.
    if(!$page = \Drupal::routeMatch()->getParameter('page_offset')) {
      $page = $config->get('page_offset');
    }
    if(!$setName = \Drupal::routeMatch()->getParameter('set_name')) {
      $setName = $config->get('set_name');
    }
    if(!$type = \Drupal::routeMatch()->getParameter('type')) {
      $type = 'Pokémon';
    }

    // Retrieving some settings.
    $pageSize = $config->get('page_cards_total');

    // Getting the cards
    $cards = Pokemon::Card()->where([
      'set.name' => $setName,
      'supertype' => $type,
      // 'types' => 'dragon',
      // 'name' => 'PikachuV',
      // 'supertype' => 'trainer',
      // 'subtypes' => 'stadium'
    ])->page($page)->pageSize($pageSize)->all();

    // Getting pagination information.
    $pagination = Pokemon::Card()->where([
      'set.name' => $setName,
      'supertype' => $type
    ])->page($page)->pageSize($pageSize)->pagination();

    dump($pagination);

    // Setting up render array.
    $render = [
      'search' => $form
    ];

    // Putting the cards within the render array.
    foreach($cards as $card) {
      $render[] = [
        '#markup' => '<a href="/pokemon/' . $card->getId() . '"><img src="' . $card->getImages()->getSmall() . '"/></a>'
      ];
    }

    // Adding pagination buttons
    if($page > 0) {
      $previousPage = '<a href="'. $page-1 .'">Previous</a>';
    } else {
      $previousPage = '';
    }
    dump($pagination->getTotalCount() % $pageSize);
    // if($pagination->getTotalCount() % $pageSize == 0) {

    // }
    $render[] = [
      '#markup' => $previousPage . '<a href="'. $page+1 .'">Next</a>'
    ];

    return $render;
  } // end of Gallery


  /**
   * Return data of one card by the given id.
   *
   * @return array
   *    Render array.
   */
  public function Card(): array
  {
    // Setting the Api Key
    Pokemon::ApiKey('b942ea9a-c062-453f-b728-f9fa7a8d133e');

    // Retrieving param card id.
    $id = \Drupal::routeMatch()->getParameter('id');

    // Prepare render array.
    $render = [
      '#theme' => 'pokecard_detail'
    ];

    // Get card by id.
    try {
      $card = Pokemon::Card()->find($id);
      $render['#card'] = '<img src="' . $card->getImages()->getLarge() . '"/>';
    } catch (InvalidArgumentException $e) {
      $render['#card'] = '<h1>No card found with id "'. $id .'"</h1>';
    }

    return $render;
  } // end of Card

}
