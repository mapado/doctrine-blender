<?php

namespace Mapado\DoctrineBlender;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;

use Mapado\DoctrineBlender\Configuration\ConfigurationInterface;

/**
 * ObjectBlender
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ObjectBlender
{
    /**
     * eventListener
     *
     * @var EventListener
     * @access private
     */
    private $eventListener;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->eventListener = new EventListener;
    }

    /**
     * Map an external association between two differents Object Manager
     *
     * @param ObjectManager $objectManager The source object manager containing the object
     * @param string $className the class name of the object containing the external id
     * @param string $propertyName the property name of the external object
     * @param string $referenceGetter the method name to get the external object id
     * @param ObjectManager $referenceManager the external object manager
     * @param string $referenceClassName the external object class name
     * @access public
     * @return void
     */
    public function mapExternalAssociation(
        ObjectManager $objectManager,
        $className,
        $propertyName,
        $referenceGetter,
        ObjectManager $referenceManager,
        $referenceClassName
    ) {
        // @See https://github.com/doctrine/common/issues/336
        //if (!($referenceManager instanceof DocumentManager || $referenceManager instanceof EntityManagerInterface)) {
        if (!(method_exists($referenceManager, 'getReference'))) {
            $msg = '$referenceManager needs to implements a `getReference` method';
            throw new \InvalidArgumentException($msg);
        }

        $this->eventListener->addExternalAssoctiation(
            $className,
            [
                'refManager' => $referenceManager,
                'propertyName' => $propertyName,
                'refClassName' => $referenceClassName,
                'refGetter' => $referenceGetter,
            ]
        );


        $objectManager->getEventManager()
            ->addEventListener(['postLoad'], $this->eventListener);
        // todo switch to doctrine event when https://github.com/doctrine/common/pull/335 is merged
    }

    /**
     * loadConfiguration
     *
     * @param Configuration $configuration
     * @access public
     * @return ObjectBlender
     */
    public function loadConfiguration(ConfigurationInterface $configuration)
    {
        $extAssocList = $configuration->getExternalAssociations();
        foreach ($extAssocList as $extAssoc) {
            $this->mapExternalAssociation(
                $extAssoc['source_object_manager'],
                $extAssoc['classname'],
                $extAssoc['property_name'],
                $extAssoc['reference_getter'],
                $extAssoc['reference_object_manager'],
                $extAssoc['reference_class']
            );
        }
        return $this;
    }
}
