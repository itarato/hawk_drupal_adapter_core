<?php
/**
 * @file
 */

namespace Drupal\hawk_connector_example\Event;

use Symfony\Component\EventDispatcher\Event;

class ListFieldDefinitionEvent extends Event {

  const TAG = 'hawk_core_list_field_definition';

  /**
   * @var string
   */
  private $fieldNames = [];

  /**
   * @return string
   */
  public function getFieldNames() {
    return $this->fieldNames;
  }

  public function addField($fieldName) {
    $this->fieldNames[] = $fieldName;
  }

}
