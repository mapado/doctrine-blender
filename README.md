doctrine-blender
================

This package makes it really simple to "blend" doctrine entities (ORM, ODM, etc.).\
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
    $eventSubscriber->blend(
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
    $eventSubscriber->blend(
        $entityManager,
        'Acme\Entity\Order',
        'product',
        'getProductId',
        $secondEntityManager,
        'Acme\Document\Product'
    );
```
