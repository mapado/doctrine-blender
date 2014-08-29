<?php

namespace Mapado\DoctrineBlender;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * EventListener
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class EventListener
{
    /**
     * externalAssociationList
     *
     * @var array
     * @access private
     */
    private $externalAssociationList;

    /**
     * addExternalAssoctiation
     *
     * @param string $className
     * @param array $associationInfo
     * @access public
     * @return EventListener
     */
    public function addExternalAssoctiation($className, array $associationInfo)
    {
        $this->externalAssociationList[$className] = $associationInfo;
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


        if (isset($this->externalAssociationList[$entityClass])) {
            $blend = $this->externalAssociationList[$entityClass];

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
