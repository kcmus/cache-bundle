Aequasi cache-bundle [![Build Status](https://travis-ci.org/aequasi/cache-bundle.png?branch=master)](https://travis-ci.org/aequasi/cache-bundle)
***

##### Forked to KCMUS 
https://github.com/aequasi/cache-bundle

commit hash 04a0db97bd5edde4f77552be2a5510349ff2ba85

Needs to be updated to use PHP-Cache
***

#### Cache Bundle for Symfony 2

Creates services in Symfony 2, for cache, that can also be used with doctrines three cache types (metadata, result, and query). It also provides functionality for session handler support, and Router support.

Should work in all versions of Symfony, and php 5.3

The respective cache extensions will be required for your project.

Redis uses the php redis extension.

#### Requirements

- PHP 5.3.x or 5.4.x
- [Composer](http://getcomposer.org)

#### To Install

Run the following in your project root, assuming you have composer set up for your project
```sh
composer.phar require aequasi/cache-bundle dev-master
```

Add the bundle to app/AppKernel.php

```php
$bundles(
    ...
       new Aequasi\Bundle\CacheBundle\AequasiCacheBundle(),
    ...
);
```

Then add parameters (probably in config.yml) for your servers, and options

```yml
kcmus_cache:
    instances:
        default:
          persistent: true # Boolean or persistent_id
          namespace: mc
          type: memcached
          hosts:
              - { host: localhost, port: 11211 }
```

To see all the config options, run `php app/console config:dump-reference kcmus_cache` to view the config settings


#### Doctrine

This bundle allows you to use its services for Doctrine's caching methods of metadata, result, and query.

If you want doctrine to use this as the result and query cache, add this

```yml
kcmus_cache:
    doctrine:
        enabled: true
        metadata:
            instance: default
            entity_managers:   [ default ]          # the name of your entity_manager connection
            document_managers: [ default ]       # the name of your document_manager connection
        result:
            instance: default
            entity_managers:   [ default, read ]  # you may specify multiple entity_managers
        query:
            instance: default
            entity_managers: [ default ]
```

#### Session

This bundle even allows you to store your session data in one of your cache clusters. To enable:

```yml
kcmus_cache:
    session:
        enabled: true
        instance: default
        prefix: "session_"
        ttl: 7200
```

#### Router

This bundle also provides router caching, to help speed that section up. To enable:

```yml
kcmus_cache:
    router:
        enabled: true
        instance: default
```

If you change any of your routes, you will need to clear all of the route_* keys in your cache.


#### To Use

To use this with doctrine's entity manager, just make sure you have `useResultCache` and/or `useQueryCache` set to true. If you want to use the user cache, just grab the service out of the container like so:

```php
// Change default to the name of your instance
$cache = $container->get( 'kcmus_cache.instance.default' );
// Or
$cache = $container->get( 'kcmus_cache.default' );
```

Here is an example usage of the service:

```php
$cache = $this->get( 'kcmus_cache.instance.default' );
$key = 'test';
if( $data = $cache->fetch( $key ) ) {
    print_r( $data );
} else {
    /** @var $em \Doctrine\ORM\EntityManager */
    $data = $em->find( 'AcmeDemoBundle:User', 1 );
    $cache->save( $key, $data, 3600 );
}
```

There is also the `cache()` function on the service that allows you to wrap the above, into a single function:

```php
$cache = $this->get( 'kcmus_cache.instance.default' );
$user = $cache->cache( 'test', function() use( $em ) { return $em->find( "AcmeDemoBundle:User", 1 ); }, 3600 );
var_dump( $user );
```

### Need Help?

Create an issue if you've found a bug,

or email me at aequasi@gmail.com


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/aequasi/cache-bundle/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


