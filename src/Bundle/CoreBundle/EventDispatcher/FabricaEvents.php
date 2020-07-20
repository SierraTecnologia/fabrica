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

namespace Fabrica\Bundle\CoreBundle\EventDispatcher;

final class FabricaEvents
{
    const PROJECT_CREATE = 'fabrica.project_create';
    const PROJECT_PUSH   = 'fabrica.project_push';
    const PROJECT_DELETE = 'fabrica.project_delete';
}
