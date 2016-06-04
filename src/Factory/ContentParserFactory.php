<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Factory;

use Drupal\hawk_core\ContentParser;

class ContentParserFactory implements ContentParserFactoryInterface {

  public function get($body, $newBasePath) {
    return new ContentParser($body, $newBasePath);
  }

}
