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

namespace Fabrica\Bundle\CoreBundle\Git;

use Fabrica\Models\Code\Project;

class PushTarget
{
    protected $project;
    protected $reference;

    public function __construct(Project $project, $reference)
    {
        $this->project = $project;
        $this->reference = $reference;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
