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

namespace Fabrica\Bundle\CoreBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\PushReferenceEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Fabrica\Bundle\CoreBundle\Git\RepositoryPool;
use Finder\Models\Code\Feed;
use Finder\Models\Code\Message;
use Finder\Models\Code\Message\OpenMessage;

/**
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
class FeedListener implements EventSubscriberInterface
{
    protected $registry;
    protected $repositoryPool;

    public function __construct(Registry $registry, RepositoryPool $repositoryPool)
    {
        $this->registry       = $registry;
        $this->repositoryPool = $repositoryPool;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FabricaEvents::PROJECT_PUSH => array(array('onProjectPush', -256)),
        );
    }

    public function onProjectPush(PushReferenceEvent $event): void
    {
        $em        = $this->registry->getManager();
        $feed      = $this->getFeed($event);
        $reference = $event->getReference();

        if ($reference->isCreate()) {
            $message = new OpenMessage($feed, $event->getUser());
            $em->persist($message);
            // used to save the open message before the commit message
            $em->flush();
        }

        $message = $this->getMessageFromEvent($event, $feed);

        if ($message) {
            $em->persist($message);
            $em->flush();
        }
    }

    /**
     * @return Message\CloseMessage|Message\CommitMessage|null
     */
    protected function getMessageFromEvent(PushReferenceEvent $event, Feed $feed)
    {
        return Message::createFromEvent($event, $feed);
    }

    protected function getFeed(PushReferenceEvent $event)
    {
        $em   = $this->registry->getManager();
        $repo = $em->getRepository('FabricaCoreBundle:Feed');
        $project = $event->getProject();
        $reference = $event->getReference()->getReference();

        return $repo->findOneOrCreate($project, $reference);
    }
}
