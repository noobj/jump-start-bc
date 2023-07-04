<?php

namespace Drupal\calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CalculatorForm extends FormBase {

	public function getFormId() {
		return 'my_calculator';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$form['status'] = [
			'#type' => 'select',

			'#title' => t('Marital status'),
			'#default_value' => 0,
			'#options' => [
				0 => $this
					->t('Single'),
				1 => $this
					->t('Married'),
				2 => $this
					->t('Married With Kid(s)'),
			],
			'#required' => TRUE,
			'#attributes' => [
				// Define a static id, so we can easier select it.
				'id' => 'field_status_select',
			],
		];

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

		$form['area'] = [
			'#type' => 'radios',
			'#title' => t('Area to live'),
			'#default_value' => 'burnaby',
			'#options' => [
				'burnaby' => t('Burnaby'),
				'downtown' => t('Downtown'),
				'newwest' => t('New West'),
			],
			'#required' => TRUE,
		];

		$form['houseType'] = [
			'#type' => 'radios',
			'#title' => t('Type of house'),
			'#default_value' => 'studio',
			'#options' => [
				'share_house' => t('Share House'),
				'studio' => t('Studio'),
				'1_bedroom_apartment' => t('1 Bedroom'),
				'2_bedroom_apartment' => t('2 Bedrooms')
			],
			'#required' => TRUE,
		];

		$form['car'] = [
			'#type' => 'radios',
			'#title' => t('Will you own a car?'),
			'#default_value' => 0,
			'#options' => [
				true => t('Yes'),
				false => t('No'),
			],
			'#required' => TRUE,
		];

		$form['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
		];

		return $form;
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$form_state->setRedirect('calculator_result',
			[
				'area' => $form_state->getValue('area'),
				'status' => $form_state->getValue('status'),
				'kids' => $form_state->getValue('kids'),
				'car' => $form_state->getValue('car'),
				'houseType' => $form_state->getValue('houseType')
			]
		);
	}

}

?>
