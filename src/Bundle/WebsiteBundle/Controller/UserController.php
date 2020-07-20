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

namespace Fabrica\Bundle\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Siravel\Models\Components\Code\UserSshKey;
use Siravel\Models\Components\Code\Email;

class UserController extends Controller
{
    public function showAction(Request $request, $username)
    {
        $this->assertGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->findByUsername($username);
        $page = $request->query->get('page', 1);

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $projects = $this->getRepository('FabricaCoreBundle:Project')->findByUser($user);
        } else {
            $projects = $this->getRepository('FabricaCoreBundle:Project')->findByUsers(array($user, $this->getUser()));
        }

        $newsfeed = $this->getRepository('FabricaCoreBundle:Message')->getPagerForUser($user, $projects)->setPage($page);

        return $this->render('FabricaWebsiteBundle:User:show.html.twig', array(
            'user'     => $user,
            'projects' => $projects,
            'newsfeed' => $newsfeed,
        ));
    }

    protected function findByUsername($username)
    {
        $repo = $this->getRepository('FabricaCoreBundle:User');
        if (!$user = $repo->findOneBy(array('username' => $username))) {
            throw $this->createNotFoundException(sprintf('No User found with username "%s".', $username));
        }

        return $user;
    }
}
