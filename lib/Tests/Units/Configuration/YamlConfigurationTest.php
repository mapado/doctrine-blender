<?php

namespace Mapado\DoctrineBlender\Tests\Units\Configuration;

use Mapado\DoctrineBlender\Configuration\YamlConfiguration;

/**
 * YamlConfigurationTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class YamlConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testEmptyFile
     *
     * @access public
     * @return void
     */
    public function testEmptyFile()
    {
        $config = new YamlConfiguration($this->getFixturePath() . 'empty.yml');
        $this->assertInstanceOf('Mapado\DoctrineBlender\Configuration\ConfigurationInterface', $config);
        $this->assertEmpty($config->getExternalAssociations());
    }

    /**
     * testBasicConfiguration
     *
     * @access public
     * @return void
     */
    public function testBasicConfiguration()
    {
        $config = new YamlConfiguration($this->getFixturePath() . 'basic.yml');
        $this->assertInstanceOf('Mapado\DoctrineBlender\Configuration\ConfigurationInterface', $config);
        $assoc = $config->getExternalAssociations();
        $this->assertEquals(count($assoc), 0);

        // add object manager reference
        $config->setObjectManagerReference('product_om', $this->getObjectManagerMock());
        $config->setObjectManagerReference('order_om', $this->getObjectManagerMock());
        $config->setObjectManagerReference('article_om', $this->getObjectManagerMock());
        $config->setObjectManagerReference('tag_om', $this->getObjectManagerMock());
        $assoc = $config->getExternalAssociations();
        $this->assertEquals(count($assoc), 2);

        $curAssoc = $assoc['product_order'];
        $this->assertInstanceOf('Mapado\DoctrineBlender\ExternalAssociation', $curAssoc);
        $this->assertEquals($curAssoc->getPropertyName(), 'order');
        $this->assertEquals($curAssoc->getClassName(), 'Entity\Product');
        $this->assertEquals($curAssoc->getReferenceIdGetter(), 'getOrderId');
        $this->assertEquals($curAssoc->getReferenceSetter(), 'setOrder');
        $this->assertEquals($curAssoc->getReferenceClassName(), 'Entity\Order');

        $curAssoc = $assoc['another_link'];
        $this->assertInstanceOf('Mapado\DoctrineBlender\ExternalAssociation', $curAssoc);
        $this->assertEquals($curAssoc->getReferenceIdGetter(), 'getTagId');
        $this->assertEquals($curAssoc->getReferenceSetter(), 'setTag');
    }

    private function getObjectManagerMock()
    {
        return $this->getMock('\Doctrine\Common\Persistence\ObjectManager');
    }

    /**
     * getFixturePath
     *
     * @access private
     * @return string
     */
    private function getFixturePath()
    {
        return __DIR__ . '/../Fixtures/Configuration/Yaml/';
    }
}
