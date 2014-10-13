<?php

namespace Mapado\DoctrineBlender;


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
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs|\Mapado\DoctrineBlender\Event\ObjectEvent $eventArgs
     * @access public
     *
     * @return void
     */
    public function postLoad($eventArgs)
    {
        if (!method_exists($eventArgs, 'getObject')) {
            throw new \InvalidArgumentException('$eventArgs must implement a `getObject` method');
        }

        $object = $eventArgs->getObject();

        $classList = array_keys($this->externalAssociationList);
        foreach ($classList as $className) {
            if (is_a($object, $className)) {
                $blendList = $this->externalAssociationList[$className];
                foreach ($blendList as $blend) {
                    $identifier = $object->{$blend->getReferenceIdGetter()}();

                    if ($identifier) {

                        $setter = $blend->getReferenceSetter();

                        if (is_array($identifier) || $identifier instanceof Iterator) {
                            $referenceList = [];
                            foreach ($identifier as $scalarIdentifier) {
                                $referenceList[] = $blend->getReferenceManager()
                                ->getReference($blend->getReferenceClassName(), $scalarIdentifier);
                            }
                            $object->{$setter}($referenceList);

                        } else {
                            $reference = $blend->getReferenceManager()
                                ->getReference($blend->getReferenceClassName(), $identifier);

                            $object->{$setter}($reference);
                        }
                    }
                }
            }
        }
    }
}
