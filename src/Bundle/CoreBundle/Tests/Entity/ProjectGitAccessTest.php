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

namespace Fabrica\Bundle\CoreBundle\Tests\Entity;

use Fabrica\Models\Code\Project;
use Fabrica\Models\Code\ProjectGitAccess;

class ProjectGitAccessTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideMatches
     *
     * @return void
     */
    public function testMatches($pattern, $reference, $expected): void
    {
        $project = new Project('foo', 'foo');
        $access = new ProjectGitAccess($project);
        $access->setReference($pattern);

        $this->assertEquals($expected, $access->matches($reference));
    }

    /**
     * @return (bool|string)[][]
     *
     * @psalm-return array{0: array{0: '*', 1: 'refs/heads/master', 2: true}, 1: array{0: 'master', 1: 'refs/heads/master', 2: true}, 2: array{0: 'feat-', 1: 'refs/heads/feat-bug', 2: false}, 3: array{0: 'feat-*', 1: 'refs/heads/feat-bug', 2: true}}
     */
    public function provideMatches(): array
    {
        return array(
            array('*',       'refs/heads/master',   true),
            array('master',  'refs/heads/master',   true),
            array('feat-',   'refs/heads/feat-bug', false),
            array('feat-*',  'refs/heads/feat-bug', true)
        );
    }

    /**
     * @dataProvider provideVerifyPermission
     *
     * @return void
     */
    public function testVerifyPermission($write, $admin, $permission, $expected): void
    {
        $project = new Project('foo', 'foo');
        $access = new ProjectGitAccess($project);
        $access->setWrite($write);
        $access->setAdmin($admin);

        $this->assertEquals($expected, $access->verifyPermission($permission));
    }

    /**
     * @return (bool|int)[][]
     *
     * @psalm-return array{0: array{0: false, 1: false, 2: 1, 3: false}, 1: array{0: true, 1: false, 2: 1, 3: true}, 2: array{0: true, 1: false, 2: 2, 3: false}, 3: array{0: true, 1: true, 2: 2, 3: true}}
     */
    public function provideVerifyPermission(): array
    {
        return array(
            array(false, false, ProjectGitAccess::WRITE_PERMISSION, false),
            array(true,  false, ProjectGitAccess::WRITE_PERMISSION, true),
            array(true,  false, ProjectGitAccess::ADMIN_PERMISSION, false),
            array(true, true,   ProjectGitAccess::ADMIN_PERMISSION, true),
        );
    }
}
