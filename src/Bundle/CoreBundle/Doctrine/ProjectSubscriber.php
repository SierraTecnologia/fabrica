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

namespace Fabrica\Bundle\CoreBundle\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

use Finder\Models\Code\Project;
use Fabrica\Bundle\CoreBundle\Git\RepositoryPool;

class ProjectSubscriber implements EventSubscriber
{
    protected $repositoryPool;

    public function __construct(RepositoryPool $repositoryPool)
    {
        $this->repositoryPool = $repositoryPool;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad
        );
    }

    /**
     * @return void
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Project) {
            return;
        }

        $entity->setRepository($this->repositoryPool->getGitRepository($entity));
    }
}
