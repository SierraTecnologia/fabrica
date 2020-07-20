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

namespace Fabrica\Bundle\CoreBundle\Git;

use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Fabrica\Bundle\CoreBundle\Git\RepositoryPool;

class HookInjector
{
    protected $hooks;

    public function __construct(array $hooks)
    {
        $this->hooks = $hooks;
    }

    public function onProjectCreate(ProjectEvent $event)
    {
        $hooks = $event->getProject()->getRepository()->getHooks();

        foreach ($this->hooks as $name => $file) {
            $hooks->setSymlink($name, $file);
        }
    }
}
