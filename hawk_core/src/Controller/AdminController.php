<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\hawk_core\ContentListCompiler;
use Drupal\hawk_core\Factory\ContentParserFactory;
use Drupal\hawk_core\PackageDownloader;
use Drupal\node\NodeInterface;

class AdminController extends ControllerBase {

  public function contentList() {
    $out = [
      'table' => [
        '#type' => 'table',
        '#header' => [t('Title'), NULL],
        '#empty' => t('There is no content.'),
      ],
    ];

    $nodes = hawk_core_packaging()->getAvailableContentList();
    foreach ($nodes as $node) {
      $packageLink = Link::createFromRoute(t('package'), 'hawk.admin.content_admin.package', ['node' => $node->id()]);
      $out['table'][$node->id()] = [
        'title' => [
          '#type' => 'markup',
          '#markup' => $node->getTitle(),
        ],
        'package' => [
          '#type' => 'markup',
          '#markup' => $packageLink->toString(),
        ],
      ];
    }

    return $out;
  }

  public function contentPackage(NodeInterface $node) {
    $downloadDir = DRUPAL_ROOT . DIRECTORY_SEPARATOR . PublicStream::basePath() . DIRECTORY_SEPARATOR . 'hawk_packages';
    $zipper = new \ZipArchive();
    // @TODO delete before creation
    $isZipCreated = $zipper->open($downloadDir . DIRECTORY_SEPARATOR . $node->id() . '.zip', \ZipArchive::CREATE);
    assert($isZipCreated);

    $listCompiler = new ContentListCompiler($node);
    $listCompiler->discoverRelatedItems();
    $nodeList = $listCompiler->getList();

    foreach ($nodeList as $idx => $subNode) {
      $downloader = new PackageDownloader(new ContentParserFactory(), $downloadDir, (string) $node->id());
      $downloader->getPage($subNode->toUrl()->setAbsolute()->toString(), "node_{$subNode->id()}.html");

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
