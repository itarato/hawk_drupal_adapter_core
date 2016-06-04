<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

use Drupal\Core\Url;
use Drupal\hawk_core\Controller\ContentParserInterface;
use Drupal\hawk_core\Factory\ContentParserFactoryInterface;
use Drupal\hawk_core\Util\WebLocation;

class PackageDownloader {

  /**
   * @var \GuzzleHttp\Client
   */
  private $httpClient;

  /**
   * @var \Drupal\hawk_core\Factory\ContentParserFactoryInterface
   */
  private $contentParserFactory;

  /**
   * @var string
   */
  private $packageDirectoryName;

  /**
   * @var string
   */
  private $downloadPath;

  /**
   * @var string[]
   */
  private $files = [];

  public function __construct(ContentParserFactoryInterface $contentParserFactory, $downloadPath, $packageDirectoryName) {
    $this->httpClient = \Drupal::httpClient();
    $this->contentParserFactory = $contentParserFactory;
    $this->packageDirectoryName = $packageDirectoryName;
    $this->downloadPath = $downloadPath;
  }
  
  public function getMainPage($url) {
    $body = $this->download($url);

    $parser = $this->contentParserFactory->get($body, '/' . $this->packageDirectoryName . '/');
    $bodyParsed = $parser->parse();

    $this->save($bodyParsed, '', 'index.html');

    foreach ($parser->getAssets() as $asset) {
      $webLoc = new WebLocation($asset);
      if (!$webLoc->isFileResource()) continue;

      $content = $this->download(Url::fromUri('base://' . $webLoc->getPath())->setAbsolute()->toString());
      $this->save($content, $webLoc->getDirname(), $webLoc->getFileName());
    }
  }

  protected function save($content, $fileRelativeFolder, $fileName) {
    $downloadFolderFullPath = $this->downloadPath . DIRECTORY_SEPARATOR . $this->packageDirectoryName . DIRECTORY_SEPARATOR . $fileRelativeFolder;
    file_prepare_directory($downloadFolderFullPath, FILE_CREATE_DIRECTORY);
    $downloadFileFullPath = $downloadFolderFullPath . DIRECTORY_SEPARATOR . $fileName;
    $file = fopen($downloadFileFullPath, 'w');
    fwrite($file, $content);
    fclose($file);

    $this->files[$downloadFileFullPath] = $fileRelativeFolder . DIRECTORY_SEPARATOR . $fileName;
  }

  protected function download($url) {
    $response = $this->httpClient->get($url);
    return (string) $response->getBody();
  }

  /**
   * @return string[]
   */
  public function getFiles() {
    return $this->files;
  }

}
