<?php
/**
 * @file
 */

namespace Drupal\hawk_connector_example;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\hawk_connector_example\Service\HawkPackagingService;
use Drupal\hawk_core\Config;

class HawkConnectorExampleServiceProvider extends ServiceProviderBase {

  public function alter(ContainerBuilder $container) {
    parent::alter($container);

    $packagingServiceDefinition = $container->getDefinition(Config::SERVICE_PACKAGING);
    $packagingServiceDefinition->setClass(HawkPackagingService::class);
  }

}
