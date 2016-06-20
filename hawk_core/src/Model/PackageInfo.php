<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Model;

use Drupal;

class PackageInfo {

  private $nid;

  private $packageGenerated;

  private $isNew;

  private function __construct($nid, $packageGenerated = 0, $isNew = TRUE) {
    $this->nid = $nid;
    $this->packageGenerated = $packageGenerated;
    $this->isNew = $isNew;
  }

  public static function loadByNid($nid) {
    $row = Drupal::database()
      ->select('hawk_core_package_info', 'hcpi')
      ->fields('hcpi')
      ->condition('hcpi.nid', $nid)
      ->execute()
      ->fetchObject();
    if (!$row) {
      return new PackageInfo($nid);
    }
    return new PackageInfo($row->nid, (int) $row->package_generated, FALSE);
  }

  public function save() {
    Drupal::database()
      ->merge('hawk_core_package_info')
      ->key(['nid' => $this->nid])
      ->fields(['package_generated' => $this->getPackageGenerated()])
      ->execute();
    $this->isNew = FALSE;
  }

  /**
   * @param int $packageGenerated
   */
  public function setPackageGenerated($packageGenerated) {
    $this->packageGenerated = $packageGenerated;
  }

  /**
   * @return int
   */
  public function getPackageGenerated() {
    return $this->packageGenerated;
  }

  /**
   * @return boolean
   */
  public function isNew() {
    return $this->isNew;
  }

}
