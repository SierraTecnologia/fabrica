<?php

namespace Fabrica\QA;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

use Behat\Behat\Extension\ExtensionInterface;

class FabricaExtension implements ExtensionInterface
{
    function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('fabrica.kernel_factory.app_dir', $config['app_dir']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load('fabrica.xml');
    }

    function getConfig(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
            ->scalarNode('app_dir')->isRequired()->end()
            ->end();
    }

    function getCompilerPasses()
    {
        return array();
    }
}
