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

namespace Fabrica\Bundle\CoreBundle\DataFixtures\ORM\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;

use Fabrica\Bundle\CoreBundle\DataFixtures\ORM\Fixture;
use Fabrica\Models\Code\Project;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;

/**
 * @author Julien DIDIER <julien@jdidier.net>
 */
class LoadProjectData extends Fixture
{
    protected $container;

    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager)
    {
        $foobar = new Project('Foobar', 'foobar');
        $foobar->setRepositorySize(256);
        $foobar->setDefaultBranch('new-feature');
        $manager->persist($foobar);
        $this->setReference('project-foobar', $foobar);
        $this->dispatch($foobar);

        $empty = new Project('Empty', 'empty');
        $empty->setRepositorySize(256);
        $manager->persist($empty);
        $this->setReference('project-empty', $empty);
        $this->dispatch($empty);

        $barbaz = new Project('Barbaz', 'barbaz');
        $barbaz->setRepositorySize(352);
        $manager->persist($barbaz);
        $this->setReference('project-barbaz', $barbaz);
        $this->dispatch($barbaz);

        $secret = new Project('Secret', 'secret');
        $secret->setRepositorySize(564);
        $manager->persist($secret);
        $this->setReference('project-secret', $secret);
        $this->dispatch($secret);

        $manager->flush();
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 3; // role
    }

    protected function dispatch(Project $project)
    {
        $this->container
            ->get('fabrica_core.event_dispatcher')
            ->dispatch(FabricaEvents::PROJECT_CREATE, new ProjectEvent($project))
        ;
    }
}
