Hawk Drupal 8 Server Connector
==============================

Hawk is an experimental prototype for an HTML based publishing service. The server creates the content for publication and the client side is able to fetch it.

The intention is to make both the server side and client side host independent - however at the moment (being a prototype) is very much coupled with Drupal 8 and Android.


Drupal 8 API
------------

To implement the Hawk API a custom module need to be implented. The service to override is: "hawk_code.packaging" using a ServiceProviderBase implementation:

```php
class MyModuleNameServiceProvider extends ServiceProviderBase {

  public function alter(ContainerBuilder $container) {
    parent::alter($container);

    $packagingServiceDefinition = $container->getDefinition(Drupal\hawk_core\Config\Config::SERVICE_PACKAGING);
    $packagingServiceDefinition->setClass(<MyModulePackagingServiceProvider>::class);
  }

}
```

The new service needs to implement ```Drupal\hawk_core\Service\PackagingServiceInterface```.

