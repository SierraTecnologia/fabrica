<?php

namespace Fabrica\Models\Infra\Ci\Model;

use SiUtils\Tools\Store\Factory;
use Fabrica\Models\Infra\Ci\Base\ProjectGroup as BaseProjectGroup;
use SiUtils\Tools\Store\ProjectStore;

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
