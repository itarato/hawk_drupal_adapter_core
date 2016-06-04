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
      $info['content'][] = [
        'id' => (int) $node->id(),
        'title' => $node->getTitle(),
        'package' => Url::fromUri('base:/' . PublicStream::basePath() . '/hawk_packages/' . $nid . '.zip', ['absolute' => TRUE])->toString(),
      ];
    }

    return new JsonResponse($info);
  }

}
