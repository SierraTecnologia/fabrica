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

class GitAccessCommandTest extends CommandTestCase
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

    public function testSimpleCreateCase()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:git-access create barbaz admin master 1 1');

        $this->assertEquals(0, $statusCode, 'statusCode is equal to 0');
        $this->assertEquals("The git-access was successfully created!\n", $output);

        $doctrine = $this->client->getKernel()->getContainer()->get('doctrine');

        $project   = $doctrine->getRepository('FabricaCoreBundle:Project')->findOneBySlug('barbaz');
        $role      = $doctrine->getRepository('FabricaCoreBundle:Role')->findOneBySlug('admin');
        $gitAccess = $doctrine->getRepository('FabricaCoreBundle:ProjectGitAccess')->findOneBy(array(
            'project'   => $project,
            'role'      => $role,
            'reference' => 'master',
        ));

        $this->assertNotNull($gitAccess);
    }

    public function testSimpleDeleteCase()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:git-access delete foobar visitor *');

        $this->assertEquals(0, $statusCode, 'statusCode is equal to 0');
        $this->assertEquals("The git-access was successfully deleted!\n", $output);

        $doctrine = $this->client->getKernel()->getContainer()->get('doctrine');

        $project   = $doctrine->getRepository('FabricaCoreBundle:Project')->findOneBySlug('foobar');
        $role      = $doctrine->getRepository('FabricaCoreBundle:Role')->findOneBySlug('visitor');
        $gitAccess = $doctrine->getRepository('FabricaCoreBundle:ProjectGitAccess')->findOneBy(array(
            'project'   => $project,
            'role'      => $role,
            'reference' => 'master',
        ));

        $this->assertNull($gitAccess);
    }
}
