<?php

/**
 * This file is part of Fabrica.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fabrica\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Fabrica\Bundle\CoreBundle\DependencyInjection\Compiler\AddValidationFilesPass;
use Fabrica\Bundle\CoreBundle\DependencyInjection\Compiler\AddFabricaListenersPass;

class FabricaCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddValidationFilesPass());
        $container->addCompilerPass(new AddFabricaListenersPass());
    }
}
