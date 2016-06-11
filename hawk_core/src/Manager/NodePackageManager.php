<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Manager;

use Drupal\hawk_core\Controller\FeedController;
use Drupal\node\NodeInterface;

class NodePackageManager {

  /**
   * @param \Drupal\node\NodeInterface $node
   * @return array
   */
  public static function getNodePackageInfo(NodeInterface $node) {
    $info = [
      'version' => FeedController::API_VERSION,
      'pages' => [],
    ];

    $nodeList = hawk_core_packaging()->getContentCollection($node);
    foreach ($nodeList as $nodeListItem) {
      $info['pages'][] = [
        'zipPath' => $node->id() . '/node_' . $nodeListItem->id() . '.html',
        'canonicalPath' => $nodeListItem->toUrl()->setAbsolute()->toString(),
      ];
    }

    return $info;
  }

}
