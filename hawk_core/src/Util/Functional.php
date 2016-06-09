<?php
/**
 * @file
 */

namespace Drupal\hawk_core\Util;

class Functional {
  
  /**
   * Calls a function on each element of an array and return the first non
   * empty result.
   *
   * @param array $list
   * @param callable $callable
   *  Signature:
   *    - param: value of current element in iteration
   *    - param: key of current element in iteration
   * @param mixed $defaultValue In case none of the evaluations give result.
   *
   * @return mixed
   */
  public static function first(array $list, $callable, $defaultValue = NULL) {
    foreach ($list as $key => $value) {
      $return = call_user_func($callable, $value, $key);
      if (!empty($return)) {
        return $return;
      }
    }
    return $defaultValue;
  }

}
