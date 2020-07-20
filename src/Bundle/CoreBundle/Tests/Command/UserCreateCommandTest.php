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

class UserCreateCommandTest extends CommandTestCase
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

    public function testSimpleCase()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'fabrica:user-create foo bar "foo@example.org" "Foo"');

        $this->assertEquals("The user foo was successfully created!\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();

        $user = $em->getRepository('FabricaCoreBundle:User')->findOneBy(array(
            'username' => 'foo'
        ));

        $this->assertInstanceOf('Siravel\Models\Components\Code\User', $user);

        $this->assertEquals('foo@example.org', $user->getDefaultEmail()->getEmail());
        $this->assertEquals('Foo', $user->getFullname());
    }
}
