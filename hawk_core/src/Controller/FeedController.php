<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

class FeedController extends ControllerBase {

  public function get() {
    $info = [
      'version' => '0.1',
      'content' => [
      ],
    ];

    $nids = \Drupal::entityQuery('node')->execute();
    foreach ($nids as $nid) {
      $node = Node::load($nid);

      $item = [
        'id' => (int) $node->id(),
        'title' => $node->getTitle(),
        'package' => Url::fromUri('base:/' . PublicStream::basePath() . '/hawk_packages/' . $nid . '.zip', ['absolute' => TRUE])->toString(),
        'pages' => [
          $nid . '/node_' . $nid . '.html',
        ],
      ];

      foreach ($node->field_content_list->getValue() as $val) {
        $item['pages'][] = $nid . '/node_' . $val['target_id'] . '.html';
      }

      $info['content'][] = $item;
    }

    return new JsonResponse($info);
  }

}
