<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class ContentListCompiler {

  /**
   * @var NodeInterface[]
   */
  private $list = [];

  /**
   * @var \Drupal\node\NodeInterface
   */
  private $node;

  public function __construct(NodeInterface $node) {
    $this->node = $node;
    $this->list[] = $node;
  }

  public function discoverRelatedItems() {
    $listFields = hawk_core_packaging()->getListField();
    foreach ($listFields as $listField) {
      foreach ($this->node->{$listField}->getValue() as $val) {
        $listNode = Node::load($val['target_id']);
        $this->list[] = $listNode;
      }
    }
  }

  /**
   * @return \Drupal\node\NodeInterface[]
   */
  public function getList() {
    return $this->list;
  }

}
