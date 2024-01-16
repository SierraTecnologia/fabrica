<?php

namespace Fabrica\Bundle\CoreBundle\Debug;

use Finder\Models\Code\Project;
use Fabrica\Bundle\CoreBundle\Git\RepositoryPool;
use Fabrica\Bundle\GitBundle\DataCollector\GitDataCollector;
use Integrations\Tools\Programs\Git\Repository;

class DebugRepositoryPool extends RepositoryPool
{
    protected $collector;

    public function setDataCollector(GitDataCollector $collector): void
    {
        $this->collector = $collector;
    }

    /**
     * @param Project $project
     */
    public function getGitRepository(Project $project)
    {
        $repository = parent::getGitRepository($project);

        if ($this->collector) {
            $this->collector->addRepository($repository);
        }

        return $repository;
    }
}
