<?php

namespace Fabrica\Bundle\DistributionBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class AddStepToListPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('fabrica_distribution.steps')) {
            return;
        }

        $def = $container->getDefinition('fabrica_distribution.steps');
        $services = $container->findTaggedServiceIds('install.step');

        $arg = $def->getArgument(0);
        foreach (array_keys($services) as $service) {
            $arg[] = new Reference($service);
        }
        $def->replaceArgument(0, $arg);
    }
}
