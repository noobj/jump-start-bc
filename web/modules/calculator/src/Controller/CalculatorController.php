<?php

namespace Drupal\calculator\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Drupal\calculator\Entity\Feedback;

class CalculatorController extends ControllerBase {

	public function calculate($area, $status, $kids, $car) {
		$adultsNumber = $status <= 0 ? 1 : 2;
		$totalPeopleNumber = $adultsNumber + $kids;
		$nids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost')
			->execute();

		$rentNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost_rent')
			->condition('field_area', $area)
			->execute();

		$carNids = [];
		if ($car == true)
			$carNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
			('type', 'living_cost_transportation')
				->condition('field_car', true)
				->execute();

		$transNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost_transportation')
			->condition('field_car', false)
			->execute();

		$nids = array_merge($nids, $transNids, $rentNids, $carNids);
		$nodes = Node::loadMultiple($nids);

		$list = [];
		foreach ($nodes as $node) {
			$price = (int) $node->get('field_price')
				->getString();

			$category = $node->get('field_category')
				->getString();
			$list[$category][] = [
				'title' => $node->getTitle(),
				'price' => $price,
			];
		}

		$myform = \Drupal::formBuilder()
			->getForm('Drupal\calculator\Form\FeedbackForm');

		return [
			'#theme' => 'my_template',
			'#nodes' => $list,
			'#adults' => $adultsNumber,
			'#totalPeople' => $totalPeopleNumber,
			'#form' => $myform
		];
	}

	public function generateForm() {
		$myform = \Drupal::formBuilder()
			->getForm('Drupal\calculator\Form\CalculatorForm');

		return [
			'#theme' => 'my_form',
			'#form' => $myform,
		];
	}

	public function storeFeedback($rating, $recommend, $comment) {
		$feedback = Feedback::create([
			'rating' => $rating,
			'recommend' => $recommend,
			'comment' => $comment
		]);

		$feedback->save();

		return [
			'#markup' => $this->t('Thanks for your feedback!'),
		];
	}

}
