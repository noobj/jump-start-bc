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
			'#type' => 'hidden',
			'#default_value' => 5,
		];

		$form['test'] = [
			'#markup' => '<div id="rater"></div><br />'
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

