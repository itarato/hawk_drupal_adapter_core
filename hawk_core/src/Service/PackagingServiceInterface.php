<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Service;

use Drupal\node\NodeInterface;

interface PackagingServiceInterface {

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\node\NodeInterface[]
   */
  public function getContentCollection(NodeInterface $node);

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return \Drupal\Core\Field\FieldItemInterface|NULL
   */
  public function getRepresentativeImage(NodeInterface $node);

  /**
   * @param int $limit
   * @param int $offset
   * @return NodeInterface[]
   */
  public function getAvailableContentList($limit = 10, $offset = 0);

}
