<?php
/**
 * @file
 */

namespace Drupal\hawk_connector_example\EventSubscriber;

use Drupal\hawk_connector_example\Event\ListFieldDefinitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HawkListFieldSubscriber implements EventSubscriberInterface {

  /**
   * Returns an array of event names this subscriber wants to listen to.
   *
   * The array keys are event names and the value can be:
   *
   *  * The method name to call (priority defaults to 0)
   *  * An array composed of the method name to call and the priority
   *  * An array of arrays composed of the method names to call and respective
   *    priorities, or 0 if unset
   *
   * For instance:
   *
   *  * array('eventName' => 'methodName')
   *  * array('eventName' => array('methodName', $priority))
   *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
   *
   * @return array The event names to listen to
   */
  public static function getSubscribedEvents() {
    return [
      ListFieldDefinitionEvent::TAG => ['onListFieldDefinition', 0],
    ];
  }

  public function onListFieldDefinition(ListFieldDefinitionEvent $listFieldDefinitionEvent) {

  }
  
}
