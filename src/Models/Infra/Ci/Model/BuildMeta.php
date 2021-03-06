<?php

namespace Fabrica\Models\Infra\Ci\Model;

use Fabrica\Models\Infra\Ci\Base\BuildMeta as BaseBuildMeta;
use Fabrica\Tools\Store\BuildStore;
use Fabrica\Tools\Store\Factory;

class BuildMeta extends BaseBuildMeta
{
    /**
     * @return Build|null
     */
    public function getBuild()
    {
        $buildId = $this->getBuildId();
        if (empty($buildId)) {
            return null;
        }

        /**
 * @var BuildStore $buildStore 
*/
        $buildStore = Factory::getStore('Build');

        return $buildStore->getById($buildId);
    }
}
