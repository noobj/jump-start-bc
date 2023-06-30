<?php

namespace Drupal\calculator\Controller;

use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;

class CalculatorController extends ControllerBase {

	public function calculate(Request $request) {
		$nids = \Drupal::entityQuery('node')->accessCheck(FALSE)->condition
		('type', 'living_cost')
			->execute();
		$nodes = Node::loadMultiple($nids);

		$list = [];
		foreach ($nodes as $node) {
			$category = $node->get('field_category')
				->getString();
			$list[$category][] = [
				'title' => $node->getTitle(),
				'price' => (int) $node->get('field_price')
					->getString(),
			];
		}

		return [
			'#theme' => 'my_template',
			'#nodes' => $list,
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
