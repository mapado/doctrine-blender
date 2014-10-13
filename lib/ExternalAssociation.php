<?php

namespace Mapado\DoctrineBlender;

use Doctrine\Common\Persistence\ObjectManager;

class ExternalAssociation
{
    /**
     * objectManager
     *
     * @var ObjectManager
     * @access private
     */
    private $objectManager;

    /**
     * className
     *
     * @var string
     * @access private
     */
    private $className;

    /**
     * propertyName
     *
     * @var string
     * @access private
     */
    private $propertyName;

    /**
     * referenceIdGetter
     *
     * @var string
     * @access private
     */
    private $referenceIdGetter;


    /**
     * referenceSetter
     *
     * @var string
     * @access private
     */
    private $referenceSetter;

    /**
     * referenceManager
     *
     * @var ObjectManager
     * @access private
     */
    private $referenceManager;

    /**
     * referenceClassName
     *
     * @var string
     * @access private
     */
    private $referenceClassName;

    /**
     * __construct
     *
     * @param ObjectManager $objectManager The source object manager containing the object
     * @param string $className the class name of the object containing the external id
     * @param string $propertyName the property name of the external object
     * @param ObjectManager $referenceManager the external object manager
     * @param string $referenceClassName the external object class name
     * @param string $referenceIdGetter the method name to get the external object id
     * @param string $referenceSetter the method name to set the external object id
     * @access public
     */
    public function __construct(
        $objectManager,
        $className,
        $propertyName,
        $referenceManager,
        $referenceClassName,
        $referenceIdGetter = null,
        $referenceSetter = null
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
        $this->propertyName = $propertyName;
        $this->referenceManager = $referenceManager;
        $this->referenceClassName = $referenceClassName;

        $this->referenceIdGetter = $referenceIdGetter ?: 'get' . ucfirst($propertyName) . 'Id';
        $this->referenceSetter = $referenceSetter ?: 'set' . ucfirst($propertyName);
    }

    /**
     * Gets the value of objectManager
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * Sets the value of objectManager
     *
     * @param ObjectManager $objectManager object manager
     *
     * @return ExternalAssociation
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

    /**
     * Gets the value of className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets the value of className
     *
     * @param string $className classname
     *
     * @return ExternalAssociation
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * Gets the value of propertyName
     *
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * Sets the value of propertyName
     *
     * @param string $propertyName property name
     *
     * @return ExternalAssociation
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * Gets the value of referenceIdGetter
     *
     * @return string
     */
    public function getReferenceIdGetter()
    {
        return $this->referenceIdGetter;
    }

    /**
     * Sets the value of referenceIdGetter
     *
     * @param string $referenceIdGetter reference getter
     *
     * @return ExternalAssociation
     */
    public function setReferenceIdGetter($referenceIdGetter)
    {
        $this->referenceIdGetter = $referenceIdGetter;
        return $this;
    }

    /**
     * Gets the value of referenceSetter
     *
     * @return string
     */
    public function getReferenceSetter()
    {
        return $this->referenceSetter;
    }

    /**
     * Sets the value of referenceSetter
     *
     * @param string $referenceSetter reference setter
     *
     * @return ExternalAssociation
     */
    public function setReferenceSetter($referenceSetter)
    {
        $this->referenceSetter = $referenceSetter;
        return $this;
    }

    /**
     * Gets the value of referenceManager
     *
     * @return ObjectManager
     */
    public function getReferenceManager()
    {
        return $this->referenceManager;
    }

    /**
     * Sets the value of referenceManager
     *
     * @param ObjectManager $referenceManager ref manager
     *
     * @return ExternalAssociation
     */
    public function setReferenceManager(ObjectManager $referenceManager)
    {
        $this->referenceManager = $referenceManager;
        return $this;
    }

    /**
     * Gets the value of referenceClassName
     *
     * @return string
     */
    public function getReferenceClassName()
    {
        return $this->referenceClassName;
    }

    /**
     * Sets the value of referenceClassName
     *
     * @param string $referenceClassName reference class name
     *
     * @return ExternalAssociation
     */
    public function setReferenceClassName($referenceClassName)
    {
        $this->referenceClassName = $referenceClassName;
        return $this;
    }
}
