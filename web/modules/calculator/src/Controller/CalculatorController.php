<?php

namespace Drupal\calculator\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;

class CalculatorController extends ControllerBase {

	public function calculate($area, $status, $kids, $car, $houseType) {
		$adultsNumber = $status <= 0 ? 1 : 2;
		$totalPeopleNumber = $adultsNumber + $kids;
		$nids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost')
			->execute();

		$rentNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost_rent')
			->condition('field_area', $area)
			->condition('field_house_type', $houseType)
			->execute();

		if ($car == false)
			$carNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
			('type', 'living_cost_transportation')
				->condition('field_car', false)
				->execute();
		else
			$carNids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
			('type', 'living_cost_transportation')
				->execute();

		$nids = array_merge($nids, $rentNids, $carNids);
		$nodes = Node::loadMultiple($nids);

		$total = 0;
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

			if ($category != 'Rent')
				$price = $price * $totalPeopleNumber;

			$list[$category]['total'] += $price;
			$total += $price;
		}

		return [
			'#theme' => 'my_template',
			'#nodes' => $list,
			'#total' => $total,
			'#adults' => $adultsNumber,
			'#totalPeople' => $totalPeopleNumber
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

}
