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

namespace Fabrica\Bundle\CoreBundle\Tests\Security;

use Fabrica\Bundle\CoreBundle\Security\ProjectRole;
use Fabrica\Models\Code\Project;

class ProjectRoleTest extends \PHPUnit\Framework\TestCase
{
    public function testInstanciation()
    {
        $project = new Project('project', 'project');
        $role = new ProjectRole($project, 'FOO');
        $this->assertTrue($role->isProject($project));
        $this->assertNull($role->getRole());
        $this->assertEquals('FOO', $role->getProjectRole());
    }
}
