Doctrine Blender
================

[![Build Status](https://travis-ci.org/mapado/doctrine-blender.svg?branch=master)](https://travis-ci.org/mapado/doctrine-blender)

This package makes it really simple to "blend" doctrine entities (ORM, ODM, etc.).

It is greatly inspired by the [Doctrine MongoDB ODM documentation](http://doctrine-mongodb-odm.readthedocs.org/en/latest/cookbook/blending-orm-and-mongodb-odm.html) on the subject.

## Installation
```sh
composer require "mapado/doctrine-blender:0.*"
```

## Usage

### Mixing ORM Entity and ODM Document
```php
use Mapado\DoctrineBlender\ObjectBlender;

$documentManager = ... // get a document manager
$entityManager = ... // get an entity manager

$eventSubscriber = new ObjectBlender;
$eventSubscriber->mapExternalAssociation(
    $entityManager,
    'Acme\Entity\Order',
    'product',
    'getProductId',
    $documentManager,
    'Acme\Document\Product'
);
```

### Mixing ORM Entities living in different Entity Manager
It is really easy to mix ORM Entities as well:

```php
use Mapado\DoctrineBlender\ObjectBlender;

$entityManager = ... // get an entity manager
$secondEntityManager = ... // get the second manager

$eventSubscriber = new ObjectBlender;
$eventSubscriber->mapExternalAssociation(
    $entityManager,
    'Acme\Entity\Order',
    'product',
    'getProductId',
    $secondEntityManager,
    'Acme\Document\Product'
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
        reference_getter: 'getProductId'
        reference_object_manager_alias: order_dm # another alia
        reference_class: 'Document\Order'
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
