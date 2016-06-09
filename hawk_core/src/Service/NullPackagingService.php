<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Service;

use Drupal\node\NodeInterface;

class NullPackagingService implements PackagingServiceInterface {

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\node\NodeInterface[]
   */
  public function getContentCollection(NodeInterface $node) {
    return [];
  }

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\Core\Field\FieldItemInterface
   */
  public function getRepresentativeImage(NodeInterface $node) {
    return NULL;
  }

  /**
   * @param int $limit
   * @param int $offset
   * @return NodeInterface[]
   */
  public function getAvailableContentList($limit = 10, $offset = 0) {
    return [];
  }
  
}
