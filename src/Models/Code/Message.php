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

use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\PushReferenceEvent;

use Fabrica\Models\Code\Message\CloseMessage;
use Fabrica\Models\Code\Message\CommitMessage;
use Fabrica\Models\Code\Message\ForceMessage;

/**
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
class Message
{
    protected $id;
    protected $feed;
    protected $user;
    protected $type;
    protected $publishedAt;

    /**
     * @return CloseMessage|CommitMessage|null
     */
    public static function createFromEvent(PushReferenceEvent $event, Feed $feed)
    {
        $user          = $event->getUser();
        $reference     = $event->getReference();
        $defaultBranch = $event->getProject()->getDefaultBranch();

        if ($reference->isDelete()) {
            return new CloseMessage($feed, $user);
        }

        $message = new CommitMessage($feed, $user);
        $message->setForce($reference->isForce());

        if ($reference->isCreate() && $event->getReference()->getReference() === 'refs/heads/'.$defaultBranch) {
            $revision = $reference->getRevision();
            $log      = $reference->getLog();
        } elseif ($reference->isCreate() && $reference->getRepository()->getReferences()->hasBranch($defaultBranch)) {
            $mergeBase = trim($reference->getRepository()->run('merge-base', array($defaultBranch, $reference->getAfter())));
            $revision  = $mergeBase.'..'.$reference->getAfter();
            $log       = $reference->getRepository()->getLog($revision);
        } else {
            $revision = $reference->getRevision();
            $log      = $reference->getLog();
        }

        if (count($log) == 0) {
            return;
        }

        $message->setRevision($revision);
        $message->fromLog($log);

        return $message;
    }

    public function __construct(Feed $feed, User $user, \DateTime $publishedAt = null)
    {
        $this
            ->setFeed($feed)
            ->setUser($user)
            ->setPublishedAt($publishedAt);
    }

    public function getId()
    {
        return $id;
    }

    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @return static
     */
    public function setFeed(Feed $feed): self
    {
        $this->feed = $feed;

        return $this;
    }

    public function getUser()
    {
        if (!$this->hasUser()) {
            throw new \LogicException('No user set in Message');
        }

        return $this->user;
    }

    public function hasUser(): bool
    {
        return null !== $this->user;
    }

    /**
     * @return static
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return static
     */
    public function setPublishedAt(\DateTime $publishedAt = null): self
    {
        $this->publishedAt = $publishedAt ? $publishedAt : new \DateTime();

        return $this;
    }

    /**
     * @return false|int
     */
    public function isBranch()
    {
        return preg_match('#^refs/heads/#', $this->getFeed()->getReference());
    }

    /**
     * @return false|string
     */
    public function getBranch()
    {
        if (!$this->isBranch()) {
            throw new \LogicException(sprintf('Feed "%s" is not a branch', $this->getFeed()->getReference()));
        }

        return substr($this->getFeed()->getReference(), 11); // refs/heads/
    }

    /**
     * @return false|int
     */
    public function isTag()
    {
        return preg_match('#^refs/tags/#', $this->getFeed()->getReference());
    }

    /**
     * @return false|string
     */
    public function getTag()
    {
        if (!$this->isTag()) {
            throw new \LogicException(sprintf('Feed "%s" is not a tag', $this->getFeed()->getReference()));
        }

        return substr($this->getFeed()->getReference(), 10); // refs/tags/
    }

    /**
     * @return false|string
     */
    public function getShortReferenceName()
    {
        if ($this->isTag()) {
            return $this->getTag();
        } elseif ($this->isBranch()) {
            return $this->getBranch();
        }

        throw new RuntimeException('Unable to find short reference name from '.$this->getFeed()->getReference());
    }
}
