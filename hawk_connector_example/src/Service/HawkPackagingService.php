<?php
/**
 * @file
 */

namespace Drupal\hawk_connector_example\Service;

use Drupal;
use Drupal\hawk_core\Service\PackagingServiceInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class HawkPackagingService implements PackagingServiceInterface {

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\node\NodeInterface[]
   */
  public function getContentCollection(NodeInterface $node) {
    $list = [$node];

    foreach ($node->field_content_list->getValue() as $refVal) {
      $list[] = Node::load($refVal['target_id']);
    }

    return $list;
  }

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\Core\Field\FieldItemInterface|NULL
   */
  public function getRepresentativeImage(NodeInterface $node) {
    return $node->field_image;
  }

  /**
   * @param int $limit
   * @param int $offset
   * @return NodeInterface[]
   */
  public function getAvailableContentList($limit = 10, $offset = 0) {
    $list = Drupal::entityQuery('node')
      ->sort('created', 'DESC')
      ->range($offset, $limit)
      ->execute();
    return array_map([Node::class, 'load'], $list);
  }
}
