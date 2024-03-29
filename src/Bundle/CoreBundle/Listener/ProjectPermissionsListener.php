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

namespace Fabrica\Bundle\CoreBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Finder\Models\Code\ProjectGitAccess;

/**
 * Listens to project creation. If no permissions are present
 * in the object, creates default git permissions for default
 * roles.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ProjectPermissionsListener implements EventSubscriberInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FabricaEvents::PROJECT_CREATE => array(array('onProjectCreate', 256)),
        );
    }

    /**
     * @return void
     */
    public function onProjectCreate(ProjectEvent $event)
    {
        $project = $event->getProject();

        if (count($project->getGitAccesses())) {
            return;
        }

        $em = $this->registry->getManager();

        $roles = $em->getRepository('FabricaCoreBundle:Role')->getIndexedByName(array('Lead developer', 'Developer', 'Visitor'));

        if (isset($roles['Lead developer'])) {
            $permissions[] = new ProjectGitAccess($project, $roles['Lead developer'], '*', true, true);
        }

        if (isset($roles['Developer'])) {
            $permissions[] = new ProjectGitAccess($project, $roles['Developer'], '*', true, false);
        }

        if (isset($roles['Visitor'])) {
            $permissions[] = new ProjectGitAccess($project, $roles['Visitor'], '*', false, false);
        }

        foreach ($permissions as $permission) {
            $project->getGitAccesses()->add($permission);
            $em->persist($permission);
        }
    }
}
