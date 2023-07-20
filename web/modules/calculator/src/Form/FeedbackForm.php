<?php

namespace Drupal\calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class FeedbackForm extends FormBase {

	public function getFormId() {
		return 'feedbackForm';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$form['rating'] = [
			'#type' => 'select',
			'#title' => t('How many stars would you give us?'),
			'#default_value' => 3,
			'#options' => [
				1 => $this
					->t('1'),
				2 => $this
					->t('2'),
				3 => $this
					->t('3'),
				4 => $this
					->t('4'),
				5 => $this
					->t('5'),
			],
			'#required' => TRUE,
			'#attributes' => [
				// Define a static id, so we can easier select it.
				'id' => 'field_status_select',
			],
		];

		$form['recommend'] = [
			'#type' => 'radios',
			'#title' => t('Will you recommend this calculator to others?'),
			'#default_value' => 1,
			'#options' => [
				true => t('Yes'),
				false => t('No'),
			],
			'#required' => TRUE,
		];

		$form['comment'] = [
			'#type' => 'textarea',
			'#title' => t('Leave your comment')
		];

		$form['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
		];

		return $form;
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$form_state->setRedirect('feedback_result',
			[
				'rating' => $form_state->getValue('rating'),
				'recommend' => $form_state->getValue('recommend'),
				'comment' => $form_state->getValue('comment'),
			]
		);
	}

}

