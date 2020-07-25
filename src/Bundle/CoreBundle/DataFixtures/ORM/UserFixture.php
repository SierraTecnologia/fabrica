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

namespace Fabrica\Bundle\CoreBundle\DataFixtures\ORM;

use Fabrica\Models\Code\User;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class UserFixture extends Fixture
{
    protected function setPassword(User $user, $password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $user->setPassword($password, $factory->getEncoder($user));
    }
}
