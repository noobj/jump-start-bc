<?php

namespace Drupal\calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CalculatorForm extends FormBase
{

  public function getFormId()
  {
    return 'my_calculator';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['status'] = array(
      '#type' => 'select',

      '#title' => t('Marital status'),
      '#default_value' => 0,
      '#options' => array(
        0 => $this
          ->t('Single'),
        1 => $this
          ->t('Married'),
        2 => $this
          ->t('Married With Kid(s)'),
      ),
      '#required' => TRUE,
      '#attributes' => [
        // Define a static id, so we can easier select it.
        'id' => 'field_status_select',
      ],
    );

    $form['kids'] = [
      '#type' => 'number',
      '#title' => t('How many kids do you have:'),
      '#default_value' => 0,
      '#min' => 0,
      '#states' => [
        // Show this textfield only if the radio 'other' is selected above.
        'visible' => [
          // Don't mistake :input for the type of field or for a css selector --
          // it's a jQuery selector.
          // You can always use :input or any other jQuery selector here, no matter
          // whether your source is a select, radio or checkbox element.
          ':input[id="field_status_select"]' => ['value' => '2'],
        ],
      ],
    ];

    $form['area'] = array(
      '#type' => 'radios',
      '#title' => t('Area to live'),
      '#default_value' => 'burnaby',
      '#options' => [
        'burnaby' => t('Burnaby'),
        'downtown' => t('Downtown'),
        'newwest' => t('New West'),
      ],
      '#required' => TRUE
    );

    $form['car'] = array(
      '#type' => 'radios',
      '#title' => t('Do you own a car?'),
      '#default_value' => 'no',
      '#options' => [
        'yes' => t('Yes'),
        'no' => t('No'),
      ],
      '#required' => TRUE
    );

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

//  public function validateForm(array &$form, FormStateInterface $form_state)
//  {
//    if (!is_numeric($form_state->getValue('first_digit'))) {
//      $form_state->setErrorByName('first_digit', t('The first digit must be a valid numeric value'));
//    }
//
//    if (!is_numeric($form_state->getValue('second_digit'))) {
//      $form_state->setErrorByName('second_digit', t('The second digit must be a valid numeric value'));
//    }
//  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $form_state->setRedirect('calculator_result', [],
      [
        'query' =>
          [
            'area' => $form_state->getValue('area'),
            'status' => $form_state->getValue('status'),
            'kids' => $form_state->getValue('kids'),
            'car' => $form_state->getValue('car')
          ]
      ]
    );
  }
}

?>
