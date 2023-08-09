<?php

namespace Drupal\pokedex\Form;

use Drupal\Core\Form\Formbase;
use Drupal\Core\Form\FormStateInterface;
use Pokemon\Pokemon;

/**
 * Filter to set the content of the page based on the set form fields.
 */
class PokedexFilter extends FormBase
{
  public function getFormId()
  {
    return 'pokedex_filter';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Get the default settings of pokedex.
    $config = \Drupal::config('pokedex.settings');

    // Retrieve all pokemon sets.
    $sets = Pokemon::Set()->all();

    // Retrieve all type of pokemon cards.
    $card_types = Pokemon::SuperType()->all();

    // Build options for all sets.
    foreach($sets as $set) {
      $setOptions[$set->getName()] = $set->getName();
    }

    // Build options for all super types (Energy, Pokemon and trainer).
    foreach($card_types as $card_type) {
      $cardTypeOptions[$card_type] = $card_type;
    }

    // Getting default values form the uri if available.
    if(!$defaultSetName = \Drupal::routeMatch()->getParameter('set_name')) {
      $defaultSetName = $config->get('set_name');
    }
    if(!$defaultType = \Drupal::routeMatch()->getParameter('type')) {
      $defaultType = 'Pokémon';
    }

    $form['set'] = [
      '#type' => 'select',
      '#title' => $this->t('Set'),
      '#options' => $setOptions,
      '#default_value' => [
        $defaultSetName => $defaultSetName
      ]
    ];

    $form['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => $cardTypeOptions,
      '#default_value' => [
        $defaultType => $defaultType
      ]
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search')
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Get the current page_offset and reuse it to go to the right page.
    if(!$pageOffset = \Drupal::routeMatch()->getParameter('page_offset')) {
      $pageOffset = 0;
    }

    // Redirect.
    $form_state->setRedirect('pokedex.gallery', [
      'type' => $form_state->getValue('type'),
      'set_name' => $form_state->getValue('set'),
      'page_offset' => $pageOffset,
    ]);
  }

}
