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
     * @param ExternalAssociation $externalAssociation the external association object
     * @access public
     * @return void
     */
    public function mapExternalAssociation(
        ExternalAssociation $externalAssociation
    ) {
        // @See https://github.com/doctrine/common/issues/336
        //if (!($referenceManager instanceof DocumentManager || $referenceManager instanceof EntityManagerInterface)) {
        if (!(method_exists($externalAssociation->getReferenceManager(), 'getReference'))) {
            $msg = '$referenceManager needs to implements a `getReference` method';
            throw new \InvalidArgumentException($msg);
        }

        $this->eventListener->addExternalAssoctiation($externalAssociation);


        $externalAssociation->getObjectManager()
            ->getEventManager()
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
            $this->mapExternalAssociation($extAssoc);
        }
        return $this;
    }
}
