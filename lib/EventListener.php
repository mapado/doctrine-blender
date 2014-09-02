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
        $entityClass = get_class($object);

        if (isset($this->externalAssociationList[$entityClass])) {
            $blendList = $this->externalAssociationList[$entityClass];
            foreach ($blendList as $blend) {
                $identifier = $object->{$blend->getReferenceIdGetter()}();

                if ($identifier) {
                    $setter = $blend->getReferenceSetter();
                    $reference =$blend->getReferenceManager()
                        ->getReference($blend->getReferenceClassName(), $identifier);

                    $object->{$setter}($reference);

                }
            }
        }
    }
}
