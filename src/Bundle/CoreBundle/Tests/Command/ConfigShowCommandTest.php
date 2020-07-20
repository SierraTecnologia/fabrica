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

class ConfigShowCommandTest extends CommandTestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
        $this->client->startIsolation();
    }

    public function tearDown(): void
    {
        $this->client->stopIsolation();
    }

    public function testNoParameter()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, "fabrica:config:show");

        $this->assertContains('repository_path  '.$this->getRepositoryPath(), $output);
        $this->assertRegexp('/\n$/', $output, 'Ends with an empty line');
    }

    public function testCorrectParameter()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, "fabrica:config:show repository_path");

        $this->assertEquals($this->getRepositoryPath()."\n", $output);
    }

    public function testIncorrectParameter()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, "fabrica:config:show foobarbaz");

        $this->assertNotEquals(0, $statusCode);
    }

    private function getRepositoryPath()
    {
        return self::createClient()->getKernel()->getContainer()->getParameter('repository_path');
    }
}
