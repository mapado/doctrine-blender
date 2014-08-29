<?php

namespace Mapado\DoctrineBlender\Configuration;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Parser;

class YamlConfiguration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfiguration()
    {
        $yaml = new Parser;
        $this->configuration = $yaml->parse(file_get_contents($this->filename));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function mapObjectReference($key, ObjectManager $reference)
    {
        foreach ($this->configuration['doctrine_external_association'] as &$config) {
            if ($config['source_object_manager_alias'] == $key) {
                $config['source_object_manager'] = $reference;
            }
            if ($config['reference_object_manager_alias'] == $key) {
                $config['reference_object_manager'] = $reference;
            }
        }
    }
}
