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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Finder\Models\Code\Project;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\PushReferenceEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Integrations\Tools\Programs\Git\Repository;
use Integrations\Tools\Programs\Git\Admin;

/**
 * Repository pool, containing all Git repositories.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
class RepositoryPool implements EventSubscriberInterface
{
    /**
     * Root directory of every repositories.
     *
     * @var string
     */
    protected $repositoryPath;

    /**
     * Constructor.
     *
     * @param string $repositoryPath Path to the repository root folder
     */
    public function __construct($repositoryPath)
    {
        $this->repositoryPath = $repositoryPath;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FabricaEvents::PROJECT_CREATE => array(array('onProjectCreate', 255)),
            FabricaEvents::PROJECT_DELETE => array(array('onProjectDelete', -255)),
            FabricaEvents::PROJECT_PUSH   => array(array('onProjectPush', -255))
        );
    }

    /**
     * Method called when a project is created
     *
     * @return void
     */
    public function onProjectCreate(ProjectEvent $event): void
    {
        $project = $event->getProject();

        $path = $this->getPath($project);

        Admin::init($path);

        $repository = $this->getGitRepository($project);
        $project->setRepository($repository);
        $project->setRepositorySize($repository->getSize());
    }

    /**
     * Method called when a project is deleted
     *
     * @return void
     */
    public function onProjectDelete(ProjectEvent $event): void
    {
        $path = $this->getPath($event->getProject());

        $flags = \FilesystemIterator::SKIP_DOTS;
        $iterator = new \RecursiveDirectoryIterator($path, $flags);
        $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                rmdir($file);
            }
        }
        rmdir($path);
    }

    public function onProjectPush(PushReferenceEvent $event): void
    {
        $project = $event->getProject();
        $repository = $this->getGitRepository($project);

        $project->setRepositorySize($repository->getSize());
    }

    /**
     * Returns the Git repository associated the a model project.
     *
     * @param Project $project
     *
     * @return Repository A Git repository
     */
    public function getGitRepository(Project $project): Repository
    {
        return new Repository($this->getPath($project));
    }

    /**
     * Computes the repository path for a given project.
     *
     * @return string
     */
    protected function getPath(Project $project): string
    {
        return $this->repositoryPath.'/'.$project->getSlug().'.git';
    }
}
