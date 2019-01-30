# KCM Forked - Needs to be Deprecated

This bundle has been replaced by [PHP-Cache](http://www.php-cache.com). Check it out!

Aequasi cache-bundle [![Build Status](https://travis-ci.org/aequasi/cache-bundle.png?branch=master)](https://travis-ci.org/aequasi/cache-bundle)
====================

#### Cache Bundle for Symfony 2

Creates services in Symfony 2, for cache, that can also be used with doctrines three cache types (metadata, result, and query). It also provides functionality for session handler support, and Router support.

The respective cache extensions will be required for your project.

Redis uses the php redis extension.

#### Requirements

- PHP >= 5.6, < 7.1
- Symfony >= 2.7, < 4.0 
- [Composer](http://getcomposer.org)

#### To Install

Run the following in your project root, assuming you have composer set up for your project
```sh
composer.phar require aequasi/cache-bundle
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
aequasi_cache:
    instances:
        default:
          persistent: true # Boolean or persistent_id
          namespace: mc
          type: memcached
          hosts:
              - { host: localhost, port: 11211 }
```

To see all the config options, run `php app/console config:dump-reference aequasi_cache` to view the config settings


#### Doctrine

This bundle allows you to use its services for Doctrine's caching methods of metadata, result, and query.

If you want doctrine to use this as the result and query cache, add this

```yml
aequasi_cache:
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
aequasi_cache:
    session:
        enabled: true
        instance: default
        prefix: "session_"
        ttl: 7200
```

#### Router

This bundle also provides router caching, to help speed that section up. To enable:

```yml
aequasi_cache:
    router:
        enabled: true
        instance: default
```

If you change any of your routes, you will need to clear all of the route_* keys in your cache.


#### To Use

To use this with doctrine's entity manager, just make sure you have `useResultCache` and/or `useQueryCache` set to true. If you want to use the user cache, just grab the service out of the container like so:

```php
// Change default to the name of your instance
$cache = $container->get( 'aequasi_cache.instance.default' );
// Or
$cache = $container->get( 'aequasi_cache.default' );
```

Here is an example usage of the service:

```php
$cache = $this->get( 'aequasi_cache.instance.default' );
$item = $cache->getItem('test');
if ($item->isHit()) {
	var_dump($item->get());
	
	return;
}

$cache->saveItem('test', $em->find('AcmeDemoBundle:User', 1), 3600);
```

### Need Help?

Create an issue if you've found a bug, or ping me on twitter: @aequasi
