<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Util;

class WebLocation {

  const TYPE_CSS = 'css';
  const TYPE_JS = 'js';
  const TYPE_IMAGE = 'image';
  const TYPE_UNKNOWN = 'unknown';

  const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'svg'];
  const EXT_CSS = 'css';
  const EXT_JS = 'js';

  /**
   * @var string
   */
  private $pathRaw;

  /**
   * @var string
   */
  private $path;

  /**
   * @var string
   */
  private $pathInfo;

  /**
   * @var string
   *  self::TYPE_*
   */
  public $type;

  public function __construct($path) {
    $this->pathRaw = $path;

    $pathDecomposed = parse_url($path);
    $this->path = $pathDecomposed['path'];

    $this->pathInfo = pathinfo($this->path);

    switch (@$this->pathInfo['extension']) {
      case self::EXT_CSS:
        $this->type = self::TYPE_CSS;
        break;

      case self::EXT_JS:
        $this->type = self::TYPE_JS;
        break;

      default:
        if (in_array(@$this->pathInfo['extension'],  self::IMAGE_EXTENSIONS)) {
          $this->type = self::TYPE_IMAGE;
        }
        else {
          $this->type = self::TYPE_UNKNOWN;
        }
        break;
    }
  }

  public function isFileResource() {
    return !empty($this->type) && $this->type !== self::TYPE_UNKNOWN;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getFileName() {
    return $this->pathInfo['basename'];
  }

  public function getDirname() {
    return $this->pathInfo['dirname'];
  }

}
