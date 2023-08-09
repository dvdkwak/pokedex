<?php

namespace Drupal\poke_collection\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form to add a pokemon card to the database.
 */
class PokeCardEntityForm extends ContentEntityForm
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'poke_collection_pokecardform';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    if (!$form_state->has('entity_form_initialized')) {
      $this->init($form_state);
    }

    $form['card_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name of the card.'),
      '#placeholder' => 'Pikachu V-union',
      '#required' => TRUE
    ];

    $form['card_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Card Id as supplied by the api.'),
      '#placeholder' => 'xy1-1',
      '#required' => TRUE
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Add'
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): bool
  {
    if(empty($form['card_name']['#value']) || empty($form['card_id']['#value'])) {
      $this->messenger()->addError('Some values have not been set.');
      return false;
    }
    $data = [
      'name' => $form['card_name']['#value'],
      'api_id' => $form['card_id']['#value']
    ];
    $pokecard = \Drupal::entityTypeManager()
      ->getStorage('pokecard')
      ->create($data);
    if($pokecard->save()) {
      $this->messenger()->addStatus($this->t('The card has been saved!'));
    } else {
      $this->messenger()->addError($this->t('The card has nog been saved!'));
    }
    return true;
  }

}
