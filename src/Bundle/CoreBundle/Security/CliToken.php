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

namespace Fabrica\Bundle\CoreBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class CliToken extends AbstractToken
{
    public function getCredentials()
    {
        return array();
    }
}
