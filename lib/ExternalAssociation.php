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
     * referenceGetter
     *
     * @var string
     * @access private
     */
    private $referenceGetter;

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
     * @param string $referenceGetter the method name to get the external object id
     * @param ObjectManager $referenceManager the external object manager
     * @param string $referenceClassName the external object class name
     * @access public
     */
    public function __construct(
        $objectManager,
        $className,
        $propertyName,
        $referenceGetter,
        $referenceManager,
        $referenceClassName
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
        $this->propertyName = $propertyName;
        $this->referenceGetter = $referenceGetter;
        $this->referenceManager = $referenceManager;
        $this->referenceClassName = $referenceClassName;
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
     * Gets the value of referenceGetter
     *
     * @return string
     */
    public function getReferenceGetter()
    {
        return $this->referenceGetter;
    }

    /**
     * Sets the value of referenceGetter
     *
     * @param string $referenceGetter reference getter
     *
     * @return ExternalAssociation
     */
    public function setReferenceGetter($referenceGetter)
    {
        $this->referenceGetter = $referenceGetter;
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
