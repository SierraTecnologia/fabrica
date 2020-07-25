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

use Fabrica\Models\Code\User;
use Fabrica\Models\Code\UserRoleProject;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UserRoleCreateCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('fabrica:user-role-create')
            ->addArgument('username',     InputArgument::REQUIRED, 'Username')
            ->addArgument('role',         InputArgument::REQUIRED, 'Role name')
            ->addArgument('project',      InputArgument::OPTIONAL, 'Slug of the project')
            ->setDescription('Creates a new user')
            ->setHelp(<<<EOF
This commands allow you to create new user roles in the project.

<comment>Sample usages:</comment>

  > php app/console fabrica:user-role-create alice Developer foobar

    Adds alice as developer to the project with slug foobar

  > php app/console fabrica:user-role-create alice Administrator

    Adds alice as administrator
EOF
            )
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $username    = $input->getArgument('username');
        $roleName    = $input->getArgument('role');
        $projectSlug = $input->getArgument('project');

        $user = $em->getRepository('FabricaCoreBundle:User')->findOneByUsername($username);
        if (!$user) {
            throw new \RuntimeException(sprintf('No user with username "%s"', $username));
        }

        if ($projectSlug) {
            $project = $em->getRepository('FabricaCoreBundle:Project')->findOneBySlug($projectSlug);
            if (!$project) {
                throw new \RuntimeException(sprintf('No project with slug "%s"', $projectSlug));
            }
        } else {
            $project = null;
        }

        $role = $em->getRepository('FabricaCoreBundle:Role')->findOneByName($roleName);
        if (!$role) {
            throw new \RuntimeException(sprintf('No role with name "%s"', $roleName));
        }

        if ($project && $role->isGlobal()) {
            throw new \RuntimeException("Cannot add a global role to a project");
        } elseif (!$project && !$role->isGlobal()) {
            throw new \RuntimeException("Cannot add a project role without project slug");
        }

        if ($project) {
            $userRole = new UserRoleProject();
            $userRole->setProject($project);
            $userRole->setUser($user);
            $userRole->setRole($role);

            $em->persist($userRole);
            $em->flush();
        } else {
            $user->addGlobalRole($role);
            $em->persist($user);
            $em->flush();
        }

        $output->writeln(sprintf(
            'Added successfully <info>%s</info> as <info>%s</info>%s',
            $user->getFullname(),
            $role->getName(),
            $project ? sprintf(' to <info>%s</info>', $project->getName()) : ''
        ));

    }
}
