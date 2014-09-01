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
     * @param ExternalAssociation $externalAssociation
     * @access public
     * @return EventListener
     */
    public function addExternalAssoctiation(ExternalAssociation $externalAssociation)
    {
        $className = $externalAssociation->getClassName();
        $propertyName = $externalAssociation->getPropertyName();
        $this->externalAssociationList[$className][$propertyName] = $externalAssociation;
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
            $blendList = $this->externalAssociationList[$entityClass];
            foreach ($blendList as $blend) {
                $identifier = $object->{$blend->getReferenceGetter()}();

                if ($identifier) {
                    $activityReflProp = $entityManager->getClassMetadata($entityClass)
                        ->reflClass->getProperty($blend->getPropertyName());

                    $activityReflProp->setAccessible(true);

                    $activityReflProp->setValue(
                        $object,
                        $blend->getReferenceManager()
                            ->getReference($blend->getReferenceClassName(), $identifier)
                    );
                }
            }
        }
    }
}
