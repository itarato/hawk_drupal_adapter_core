<?php
/**
 * @file
 */

namespace Drupal\hawk_core;

class ContentParser implements ContentParserInterface {

  private $body;

  private $bodyParsed;

  private $assets = [];

  public function __construct($body) {
    $this->bodyParsed = $this->body = $body;
  }

  public function parse() {
    $relativePathFixer = [$this, 'fixRelativePath'];

    $instance = $this;

    $this->bodyParsed = preg_replace_callback('#(?<=")(?P<url>' . base_path() . '[^"]+)#', function ($matches) use ($instance, $relativePathFixer) {
      $url = $matches['url'];
      $fixedPath = call_user_func($relativePathFixer, $url);
      $instance->assets[$url] = $fixedPath;
      return $fixedPath ?: $url;
    }, $this->bodyParsed);

    return $this->bodyParsed;
  }

  public function fixRelativePath($relativePath) {
    return preg_replace('#^' . base_path() . '#', '', $relativePath);
  }

  /**
   * @return string
   */
  public function getAssets() {
    return $this->assets;
  }

}
