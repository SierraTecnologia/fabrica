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

namespace Fabrica\Models\Code\Message;

use Fabrica\Models\Code\Message;

/**
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
class PullRequestMessage extends Message
{
    protected $message;

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return static
     */
    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getName(): string
    {
        return 'pr';
    }
}
