<?php

    namespace Drupal\calculator\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Drupal\Core\Controller\ControllerBase;

    class CalculatorController extends ControllerBase  {
      public function calculate(Request $request) {
        var_dump($request->request);
        $foo = $request->request->get('area');

        return [
          '#theme' => 'my_template',
          '#test_var' => $foo
        ];
      }
    }
