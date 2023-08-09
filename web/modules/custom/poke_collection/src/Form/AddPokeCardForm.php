<?php

/**
 * @file
 *
 * Contains the AddPokeCardForm
 */

namespace Drupal\poke_collection\Form;

use Drupal\Core\Form\Formbase;
use Drupal\Core\Form\FormStateInterface;
use Pokemon\Pokemon;

class AddPokeCardForm extends Formbase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'poke_collection_add_poke_card';
  } // end of getFormId()

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Retrieve card id.
    $parameters = \Drupal::routeMatch()->getParameters();

    // Retrieve name of the card.
    $card = Pokemon::Card()->find($parameters->get('id'));

    $form['name'] = [
      '#type' => 'hidden',
      '#value' => $card->getName()
    ];

    $form['api_id'] = [
      '#type' => 'hidden',
      '#value' => $parameters->get('id')
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add this card to collection.')
    ];

    return $form;
  } // end of buildForm()

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Checking for existing pokecards with the given api_id.
    if($pokecard = \Drupal::entityTypeManager()->getStorage('pokecard')->loadByProperties([
      'api_id' => $form_state->getValue('api_id')
    ])) {
      $this->messenger()->addStatus($this->t('This card is already present in your collection.'));
      return TRUE;
    }
    // If card does not exist yet, we create it here.
    if($pokecard = \Drupal::entityTypeManager()->getStorage('pokecard')->create([
      'name' => $form_state->getValue('name'),
      'api_id' => $form_state->getValue('api_id')
    ])->save()) {
      $this->messenger()->addStatus($this->t('The card has been added to your collection!'));
    }
  } // end of submitForm()
} // end of AddPokeCardForm
