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

namespace Fabrica\Bundle\CoreBundle\Tests\Command;

use Fabrica\Bundle\CoreBundle\Test\CommandTestCase;

class UserRoleCreateCommandTest extends CommandTestCase
{
    protected $client;

    protected function setUp(): void: void
    {
        $this->client = self::createClient();
        $this->client->startIsolation();
    }

    public function tearDown(): void
    {
        $this->client->stopIsolation();
    }

    public function testProjectRole()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-role-create bob Developer barbaz');

        $this->assertEquals("Added successfully Bob as Developer to Barbaz\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();

        $user    = $em->getRepository('FabricaCoreBundle:User')->findOneByUsername('bob');
        $role    = $em->getRepository('FabricaCoreBundle:Role')->findOneByName('Developer');
        $project = $em->getRepository('FabricaCoreBundle:Project')->findOneBySlug('barbaz');
        $userRole = $em->getRepository('FabricaCoreBundle:UserRoleProject')->findOneBy(array(
            'user' => $user,
            'role' => $role,
        ));

        $this->assertInstanceOf('Fabrica\Models\Code\UserRoleProject', $userRole);
    }

    public function testGlobalRole()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-role-create bob Administrator');

        $this->assertEquals("Added successfully Bob as Administrator\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();

        $user    = $em->getRepository('FabricaCoreBundle:User')->findOneByUsername('bob');
        $role    = $em->getRepository('FabricaCoreBundle:Role')->findOneByName('Administrator');

        $this->assertTrue($user->getGlobalRoles()->contains($role));
    }

    public function testProjectRoleIncorrect()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-role-create bob Administrator barbaz');

        $this->assertContains("Cannot add a global role to a project", $output);
    }

    public function testGlobalRoleIncorrect()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-role-create bob Developer');

        $this->assertContains("Cannot add a project role without project slug", $output);
    }
}
