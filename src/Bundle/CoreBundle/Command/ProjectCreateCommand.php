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

namespace Fabrica\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Siravel\Models\Components\Code\Project;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;

/**
 * Shell command for creating a project.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ProjectCreateCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('fabrica:project-create')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the project')
            ->addArgument('slug', InputArgument::REQUIRED, 'Slug of the project')
            ->setDescription('Creates a new project and initializes its repository')
            ->setHelp(<<<EOF
The <info>fabrica:project-create</info> command creates a project and initializes
it repository.

<comment>Sample usages</comment>

  > php app/console fabrica:project-create "My Project" my-project

    Creates a new project with name "<comment>My project</comment>" and slugged "<comment>my-project</comment>"

EOF
            )
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em   = $this->getContainer()->get('doctrine')->getManager();

        $project = new Project();
        $project->setName($input->getArgument('name'));
        $project->setSlug($input->getArgument('slug'));

        $em->persist($project);
        $em->flush();

        $event = new ProjectEvent($project);
        $this->getContainer()->get('fabrica_core.event_dispatcher')->dispatch(FabricaEvents::PROJECT_CREATE, $event);

        $em->persist($project);
        $em->flush();

        $output->writeln(sprintf('Project <info>%s</info> was created!', $project->getName()));
    }
}
