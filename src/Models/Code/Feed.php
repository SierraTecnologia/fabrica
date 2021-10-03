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

namespace Fabrica\Models\Code;

use Doctrine\Common\Collections\ArrayCollection;

use Pedreiro\Models\Base;

/**
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
class Feed
{
    protected $id;
    protected $project;
    protected $reference;
    protected $messages;

    public function __construct(Project $project, $reference = null)
    {
        $this->project   = $project;
        $this->reference = $reference;
    }

    public function getId()
    {
        return $id;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
