<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Factory;

interface ContentParserFactoryInterface {

  /**
   * @param string $body
   * @param string $newBasePath
   * @return \Drupal\hawk_core\ContentParserInterface
   */
  public function get($body, $newBasePath);

}
