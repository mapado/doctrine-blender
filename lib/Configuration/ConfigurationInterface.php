<?php

namespace Mapado\DoctrineBlender\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

interface ConfigurationInterface
{
    /**
     * getExternalAssociations
     *
     * @access public
     * @return array<ExternalAssociation>
     */
    public function getExternalAssociations();

    /**
     * setObjectManagerReference
     *
     * @param string $key
     * @param ObjectManager $reference
     * @access public
     * @return Configuration
     */
    public function setObjectManagerReference($key, ObjectManager $reference);
}
