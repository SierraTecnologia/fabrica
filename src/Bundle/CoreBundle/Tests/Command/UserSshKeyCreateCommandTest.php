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

class UserSshKeyCreateCommandTest extends CommandTestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->client->startIsolation();
    }

    public function tearDown(): void
    {
        $this->client->stopIsolation();
    }

    public function testSimpleCase()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-ssh-key-create "alice" foo bar');

        $this->assertEquals("The key named foo was successfully added to user alice!\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();

        $userSshKey = $em->getRepository('FabricaCoreBundle:UserSshKey')->findOneBy(
            array(
            'title' => 'foo'
            )
        );

        $this->assertInstanceOf('Finder\Models\Code\UserSshKey', $userSshKey);

        $this->assertEquals('alice', $userSshKey->getUser()->getUsername());
        $this->assertEquals('foo', $userSshKey->getTitle());
        $this->assertEquals('bar', $userSshKey->getContent());
    }

    public function testNonExistingUser()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-ssh-key-create "foo" bar baz');

        $this->assertContains('User with username "foo" not found', $output);
    }
}
