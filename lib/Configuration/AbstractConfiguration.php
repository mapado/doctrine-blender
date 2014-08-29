<?php

namespace Mapado\DoctrineBlender\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractConfiguration implements ConfigurationInterface
{
    /**
     * filename
     *
     * @var string
     * @access protected
     */
    protected $filename;

    /**
     * objectManagerRefList
     *
     * @var array
     * @access protected
     */
    protected $objectManagerRefList;

    /**
     * configuration
     *
     * @var array
     * @access protected
     */
    protected $configuration;

    /**
     * __construct
     *
     * @param string $filename
     * @access public
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->objectManagerRefList = [];
        $this->configuration = [];
    }

    /**
     * {@inheritdoc}
     */
    public function setObjectManagerReference($key, ObjectManager $reference)
    {
        $this->objectManagerRefList[$key] = $reference;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExternalAssociations()
    {
        $this->loadConfiguration();

        foreach ($this->objectManagerRefList as $key => $omRef) {
            $this->mapObjectReference($key, $omRef);
        }

        return $this->configuration['doctrine_external_association'];
    }

    /**
     * mapObjectReference
     *
     * @param string $key
     * @param ObjectManager $reference
     * @abstract
     * @access protected
     * @return ConfigurationInterface
     */
    abstract protected function mapObjectReference($key, ObjectManager $reference);

    /**
     * loadConfiguration
     *
     * @abstract
     * @access protected
     * @return ConfigurationInterface
     */
    abstract protected function loadConfiguration();
}
