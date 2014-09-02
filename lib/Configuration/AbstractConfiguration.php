<?php

namespace Mapado\DoctrineBlender\Configuration;

use Doctrine\Common\Persistence\ObjectManager;

use Mapado\DoctrineBlender\ExternalAssociation;

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

        $externalAssocList = [];
        if (!empty($this->configuration['doctrine_external_association'])) {
            foreach ($this->configuration['doctrine_external_association'] as $key => $config) {
                if (isset($config['source_object_manager']) && isset($config['reference_object_manager'])) {

                    $refIdGetter = !empty($config['reference_id_getter']) ? $config['reference_id_getter'] : null;
                    $refSetter = !empty($config['reference_setter']) ? $config['reference_setter'] : null;
                    $externalAssocList[$key] = new ExternalAssociation(
                        $config['source_object_manager'],
                        $config['classname'],
                        $config['property_name'],
                        $config['reference_object_manager'],
                        $config['reference_class'],
                        $refIdGetter,
                        $refSetter
                    );
                }
            }
        }

        return $externalAssocList;
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
