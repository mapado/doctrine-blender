<?php

namespace Mapado\DoctrineBlender;

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ObjectBlender
{
    public function blend(
        ObjectManager $objectManager,
        $className,
        $propertyName,
        $referenceGetter,
        ObjectManager $referenceManager,
        $referenceClassName
    ) {
        if (!($referenceManager instanceof DocumentManager || $referenceManager instanceof EntityManagerInterface)) {
            $msg = '$referenceManager needs to be an instance of DocumentManager or EntityManagerInterface';
            throw \InvalidArgumentException($msg);
        }

        $this->blendList[$className] = [
            'refManager' => $referenceManager,
            'propertyName' => $propertyName,
            'refClassName' => $referenceClassName,
            'refGetter' => $referenceGetter,
        ];


        $objectManager->getEventManager()
            ->addEventListener([\Doctrine\ORM\Events::postLoad], $this);
    }


    /**
     * postLoad
     *
     * @param LifecycleEventArgs $eventArgs
     * @access public
     *
     * @return void
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        $entityManager = $eventArgs->getObjectManager();
        $entityClass = get_class($object);


        if (isset($this->blendList[$entityClass])) {
            $blend = $this->blendList[$entityClass];

            $activityReflProp = $entityManager->getClassMetadata($entityClass)
                ->reflClass->getProperty($blend['propertyName']);

            $activityReflProp->setAccessible(true);

            $activityReflProp->setValue(
                $object,
                $blend['refManager']->getReference($blend['refClassName'], $object->{$blend['refGetter']}())
            );
        }
    }
}
