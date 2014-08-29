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
        $this->assertEquals(count($assoc), 2);
        $curAssoc = $assoc['product_order'];
        $this->assertEquals($curAssoc['property_name'], 'order');
        $this->assertArrayHasKey('source_object_manager_alias', $curAssoc);
        $this->assertArrayHasKey('classname', $curAssoc);
        $this->assertArrayHasKey('property_name', $curAssoc);
        $this->assertArrayHasKey('reference_getter', $curAssoc);
        $this->assertArrayHasKey('reference_object_manager_alias', $curAssoc);
        $this->assertArrayHasKey('reference_class', $curAssoc);
        $this->assertArrayNotHasKey('source_object_manager', $curAssoc);

        // add object manager reference
        $config->setObjectManagerReference('product_om', $this->getObjectManagerMock());
        $assoc = $config->getExternalAssociations();
        $curAssoc = $assoc['product_order'];
        $this->assertArrayHasKey('source_object_manager', $curAssoc);
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
