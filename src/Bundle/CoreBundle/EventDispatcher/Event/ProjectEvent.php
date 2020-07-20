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

namespace Fabrica\Bundle\CoreBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

use Siravel\Models\Components\Code\Project;
use Siravel\Models\Components\Code\User;

class ProjectEvent extends Event
{
    protected $project;
    protected $user;

    public function __construct(Project $project, User $user = null)
    {
        $this->project = $project;
        $this->user    = $user;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function hasUser()
    {
        return null !== $this->user;
    }
}
