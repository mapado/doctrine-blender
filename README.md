Doctrine Blender
================

[![Build Status](https://travis-ci.org/mapado/doctrine-blender.svg?branch=master)](https://travis-ci.org/mapado/doctrine-blender)

This package makes it really simple to "blend" doctrine entities (ORM, ODM, etc.).

It is greatly inspired by the [Doctrine MongoDB ODM documentation](http://doctrine-mongodb-odm.readthedocs.org/en/latest/cookbook/blending-orm-and-mongodb-odm.html) on the subject.

## Current status
It should work with every doctrine package.
It is tested with Doctrine ORM and Doctrine MongoDB.

It also working with [mapado/elastica-query-bundle](https://github.com/mapado/elastica-query-bundle) in the ElasticSearch => Doctrine direction.

## Installation
```sh
composer require "mapado/doctrine-blender:0.*"
```

## Usage

### Mixing ORM Entity and ODM Document
```php
use Mapado\DoctrineBlender\ObjectBlender;
use Mapado\DoctrineBlender\ExternalAssociation;

$documentManager = ... // get a document manager
$entityManager = ... // get an entity manager

$eventSubscriber = new ObjectBlender;
$eventSubscriber->mapExternalAssociation(
    new ExternalAssociation(
        $entityManager,
        'Acme\Entity\Order',
        'product',
        $documentManager,
        'Acme\Document\Product',
        'getProductId', // optional, auto-generated with the property name
        'setProduct' // optional, auto-generated with the property name
    )
);
```

### Mixing ORM Entities living in different Entity Manager
It is really easy to mix ORM Entities as well:

```php
use Mapado\DoctrineBlender\ObjectBlender;
use Mapado\DoctrineBlender\ExternalAssociation;

$entityManager = ... // get an entity manager
$secondEntityManager = ... // get the second manager

$eventSubscriber = new ObjectBlender;
$eventSubscriber->mapExternalAssociation(
    new ExternalAssociation(
        $entityManager,
        'Acme\Entity\Order',
        'product',
        $secondEntityManager,
        'Acme\Document\Product'
    )
);
```

## Configuration
### Yaml

```yaml
doctrine_external_association:
    client_address:         # this key is only for you
        source_object_manager_alias: product_em # an alias you will need to inject later
        classname: 'Entity\Product'
        property_name: 'product'
        reference_object_manager_alias: order_dm # another alia
        reference_class: 'Document\Order'
        reference_getter: 'getProductId'
        reference_setter: 'setProduct'
```

```php
use Mapado\DoctrineBlender\Configuration\YamlConfiguration;

$ymlConf = new YamlConfiguration('/path/to/external_association.yml');

$entityManager = ... // get an entity manager
$documentManager = ... // get a document manager

$ymlConf->setObjectManagerReference('product_em', $entityManager)
    ->setObjectManagerReference('order_dm', $documentManager)
;
```
