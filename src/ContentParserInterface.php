<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

interface ContentParserInterface {

  /**
   * @return string
   */
  public function parse();

  /**
   * @return string[]
   */
  public function getAssets();

}
