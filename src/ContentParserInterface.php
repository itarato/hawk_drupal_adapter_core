<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

interface ContentParserInterface {

  public function parse();

  public function fixRelativePath($relativePath);

}
