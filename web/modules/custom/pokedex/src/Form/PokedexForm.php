<?php

namespace Drupal\Pokedex\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class PokedexForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'pokedex_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('pokedex.settings');

    // Total cards to display.
    $form['page_cards_total'] = [
      '#type' => 'number',
      '#title' => $this->t('Total cards:'),
      '#default_value' => $config->get('page_cards_total'),
      '#description' => $this->t('Number of cards to show on a page.'),
    ];
    // Default offset of the page.
    $form['page_offset'] = [
      '#type' => 'number',
      '#title' => $this->t('Page offset:'),
      '#default_value' => $config->get('page_offset'),
      '#description' => $this->t('Define the default offset on a page.'),
    ];
    // Set type you want to display.
    $form['set_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Card Set:'),
      '#default_value' => $config->get('set_name'),
      '#description' => $this->t('Define the default card set to display.'),
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // This is mandatory, but does not need to have content.
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config('pokedex.settings');
    $config->set('page_cards_total', $form_state->getValue('page_cards_total'));
    $config->set('page_offset', $form_state->getValue('page_offset'));
    $config->set('set_name', $form_state->getValue('set_name'));
    $config->save();
    return parent::
    submitForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'pokedex.settings',
    ];
  }

}
