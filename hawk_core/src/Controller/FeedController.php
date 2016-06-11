<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\Core\Url;
use Drupal\hawk_core\Manager\NodePackageManager;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FeedController extends ControllerBase {

  const API_VERSION = '0.1';

  public function contentListFeed() {
    $info = [
      'version' => self::API_VERSION,
      'content' => [
      ],
    ];

    $nodes = hawk_core_packaging()->getAvailableContentList();
    foreach ($nodes as $node) {
      $imageField = hawk_core_packaging()->getRepresentativeImage($node);

      $item = [
        'id' => (int) $node->id(),
        'title' => $node->getTitle(),
//        'content_feed' => Url::fromRoute('hawk.content_feed', ['node' => $node->id()])->setAbsolute()->toString(),
        'package' => Url::fromUri('base:/' . PublicStream::basePath() . '/hawk_packages/' . $node->id() . '.zip')->setAbsolute()->toString(),
        'image' => $imageField->entity ? $imageField->entity->url() : '',
      ];

      
      $info['content'][] = $item;
    }

    return new JsonResponse($info);
  }

  public function contentFeed(NodeInterface $node) {
    return new JsonResponse(NodePackageManager::getNodePackageInfo($node));
  }

}
