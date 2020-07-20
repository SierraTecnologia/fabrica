<?php

namespace Fabrica\Bundle\CoreBundle\Debug;

use Siravel\Models\Components\Code\Project;
use Fabrica\Bundle\CoreBundle\Git\RepositoryPool;
use Fabrica\Bundle\GitBundle\DataCollector\GitDataCollector;
use Fabrica\Tools\Programs\Git\Repository;

class DebugRepositoryPool extends RepositoryPool
{
    protected $collector;

    public function setDataCollector(GitDataCollector $collector)
    {
        $this->collector = $collector;
    }

    public function getGitRepository(Project $project)
    {
        $repository = parent::getGitRepository($project);

        if ($this->collector) {
            $this->collector->addRepository($repository);
        }

        return $repository;
    }
}
