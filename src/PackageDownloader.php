<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

use Drupal\hawk_core\Controller\ContentParserInterface;
use Drupal\hawk_core\Factory\ContentParserFactoryInterface;

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

  public function __construct(ContentParserFactoryInterface $contentParserFactory, $downloadPath, $packageDirectoryName) {
    $this->httpClient = \Drupal::httpClient();
    $this->contentParserFactory = $contentParserFactory;
    $this->packageDirectoryName = $packageDirectoryName;
    $this->downloadPath = $downloadPath;
  }
  
  public function getMainPage($url) {
    $response = $this->httpClient->get($url);
    $body = (string) $response->getBody();

    $parser = $this->contentParserFactory->get($body, '/' . $this->packageDirectoryName . '/');
    $bodyParsed = $parser->parse();

    $downloadFullPath = $this->downloadPath . DIRECTORY_SEPARATOR . $this->packageDirectoryName;
    file_prepare_directory($downloadFullPath, FILE_CREATE_DIRECTORY);
    $file = fopen($downloadFullPath . DIRECTORY_SEPARATOR . 'index.html', 'w');
    fwrite($file, $bodyParsed);
    fclose($file);
  }

}
