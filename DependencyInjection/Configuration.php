<?php

namespace DoS\TaggingBundle\DependencyInjection;

use DoS\CernelBundle\Config\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dos_tagging');

        $this->setDefaults($rootNode, array(
            'resources' => array(
                'tag' => array(
                    'classes' => array(
                        'model' => 'DoS\TaggingBundle\Model\Tag',
                        'interface' => 'DoS\TaggingBundle\Model\TagInterface',
                        'repository' => 'DoS\TaggingBundle\Doctrine\ORM\TagRepository',
                        'controller' => 'DoS\TaggingBundle\Controller\TagController',
                    ),
                    'validation_groups' => array(
                        'default' => array('dos'),
                    ),
                ),
                'tagging' => array(
                    'classes' => array(
                        'model' => 'DoS\TaggingBundle\Model\Tagging',
                        'interface' => 'DoS\TaggingBundle\Model\TaggingInterface',
                        'repository' => 'DoS\TaggingBundle\Doctrine\ORM\TaggingRepository',
                        'controller' => 'DoS\TaggingBundle\Controller\TaggingController',
                    ),
                    'validation_groups' => array(
                        'default' => array('dos'),
                    ),
                ),
            ),
        ));

        return $treeBuilder;
    }
}
