<?php

namespace Drupal\rt_library\Controller;



class ReactController {

  public function view() {
    $view['content'] = [
      '#markup' => '<div id="my-react-app"></div>'
    ];

    $view['#attached']['library'][] = 'rt_library/angular.angularjs';
    $view['#attached']['library'][] = 'rt_library/font-awesome';
    $view['#attached']['library'][] = 'rt_library/react.reactjs';


    return $view;
  }
}
