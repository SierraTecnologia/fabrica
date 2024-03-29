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

namespace Fabrica\Component\Requirements;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class WebFabricaRequirements extends FabricaRequirements
{
    public function __construct()
    {
        $this->addRequirement($this->isDocumentRoot(), 'Your app/ folder is accessible to the world');

        parent::__construct();
    }

    protected function isDocumentRoot(): bool
    {
        $request = Request::createFromGlobals();

        return !preg_match('#web/install.php$#', $request->getBaseUrl());
    }
}
