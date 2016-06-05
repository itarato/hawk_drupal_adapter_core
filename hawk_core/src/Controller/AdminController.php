<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\hawk_core\Factory\ContentParserFactory;
use Drupal\hawk_core\PackageDownloader;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class AdminController extends ControllerBase {

  public function contentList() {
    $efq = \Drupal::entityQuery('node');
    $nodeIDs = $efq->execute();

    $out = [
      'table' => [
        '#type' => 'table',
        '#header' => [t('Title'), t('Package')],
        '#empty' => t('There is no content.'),
      ],
    ];

    foreach ($nodeIDs as $nodeID) {
      $node = Node::load($nodeID);

      $adminLink = Link::createFromRoute($node->getTitle(), 'hawk.admin.content_admin', ['node' => $nodeID]);
      $packageLink = Link::createFromRoute('[=]', 'hawk.admin.content_admin.package', ['node' => $nodeID]);
      $out['table'][$nodeID] = [
        'title' => [
          '#type' => 'markup',
          '#markup' => $adminLink->toString(),
        ],
        'package' => [
          '#type' => 'markup',
          '#markup' => $packageLink->toString(),
        ],
      ];
    }

    return $out;
  }

  public function contentAdmin(NodeInterface $node) {
    return [
      '#type' => 'markup',
      '#markup' => ':)' . $node->getTitle(),
    ];
  }

  public function contentPackage(NodeInterface $node) {
    $downloadDir = DRUPAL_ROOT . DIRECTORY_SEPARATOR . PublicStream::basePath() . DIRECTORY_SEPARATOR . 'hawk_packages';
    $zipper = new \ZipArchive();
    // @TODO delete before creation
    $isZipCreated = $zipper->open($downloadDir . DIRECTORY_SEPARATOR . $node->id() . '.zip', \ZipArchive::CREATE);
    assert($isZipCreated);

    $nodeList = [
      $node,
      Node::load(1),
    ];

    foreach ($nodeList as $idx => $subNode) {
      $downloader = new PackageDownloader(new ContentParserFactory(), $downloadDir, (string) $node->id());
      $downloader->getMainPage($subNode->toUrl()->setAbsolute()->toString(), "node_{$subNode->id()}.html");

      foreach ($downloader->getFiles() as $fullPath => $relativePath) {
        $inZipPath = DIRECTORY_SEPARATOR . $node->id() . DIRECTORY_SEPARATOR . $relativePath;
        $zipper->addFile($fullPath, $inZipPath);
      }
    }
    
    $zipper->close();

    return [
      '#type' => 'markup',
      '#markup' => 'Zip package has been created.',
    ];
  }

}
