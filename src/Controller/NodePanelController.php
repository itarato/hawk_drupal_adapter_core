<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Controller;

use Drupal\Core\Controller\ControllerBase;

class NodePanelController extends ControllerBase {

  public function get() {
    // @todo This page can be for marking content for distribution.
    return [
      '#type' => 'markup',
      '#markup' => 'Hello world',
    ];
  }

}
