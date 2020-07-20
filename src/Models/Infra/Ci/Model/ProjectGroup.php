<?php

namespace Fabrica\Models\Infra\Ci\Model;

use Fabrica\Tools\Store\Factory;
use Fabrica\Models\Infra\Ci\Base\ProjectGroup as BaseProjectGroup;
use Fabrica\Tools\Store\ProjectStore;

class ProjectGroup extends BaseProjectGroup
{
    /**
     * @return Project[]
     */
    public function getGroupProjects()
    {
        /**
 * @var ProjectStore $projectStore 
*/
        $projectStore = Factory::getStore('Project');

        return $projectStore->getByGroupId($this->getId(), false);
    }
}
