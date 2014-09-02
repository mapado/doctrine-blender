<?php

namespace Mapado\DoctrineBlender\Event;

/**
 * ObjectEvent
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ObjectEvent
{
    /**
     * object
     *
     * @var object
     * @access private
     */
    private $object;

    /**
     * __construct
     *
     * @param object $object
     * @access public
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * getObject
     *
     * @access public
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }
}
