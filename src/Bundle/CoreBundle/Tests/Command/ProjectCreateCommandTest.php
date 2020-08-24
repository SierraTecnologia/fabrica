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

class ProjectCreateCommandTest extends CommandTestCase
{
    protected $client;
    protected $repositoryPool;
    protected $hookInjector;

    protected function setUp(): void: void
    {
        $this->client = self::createClient();
        $this->repositoryPool = $this->getMockBuilder('Fabrica\Bundle\CoreBundle\Git\RepositoryPool')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->hookInjector = $this->getMockBuilder('Fabrica\Bundle\CoreBundle\Git\HookInjector')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->client->setRepositoryPool($this->repositoryPool);
        $this->client->setHookInjector($this->hookInjector);

        $this->client->startIsolation();
    }

    public function tearDown(): void
    {
        $this->client->stopIsolation();
    }

    public function testSimpleCase()
    {
        $this->repositoryPool
            ->expects($this->once())
            ->method('onProjectCreate')
        ;
        $this->hookInjector
            ->expects($this->once())
            ->method('onProjectCreate')
        ;

        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:project-create "Sample name" sample-name');

        $this->assertEquals("Project Sample name was created!\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();

        $project = $em->getRepository('FabricaCoreBundle:Project')->findOneBy(array(
            'name' => 'Sample name',
            'slug' => 'sample-name'
        ));

        $this->assertNotEmpty($project);
    }
}
