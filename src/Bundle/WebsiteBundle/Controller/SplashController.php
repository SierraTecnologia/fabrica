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
use Symfony\Component\Security\Core\SecurityContext;

use Doctrine\ORM\NoResultException;

use Siravel\Models\Components\Code\User;

class SplashController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            return $this->redirect($this->generateUrl('project_list'));
        }

        $form = $this->get('form.factory')->createNamed('', 'login');

        $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        if ($error) {
            $this->setFlash('error', $this->trans('error.form_invalid', array(), 'login'));
            $request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('FabricaWebsiteBundle:Splash:login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException('You should not be able to reach this action');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You should not be able to reach this action');
    }

    public function registerAction()
    {
        if (!$this->get('fabrica_core.config')->get('open_registration')) {
            throw $this->createNotFoundException('Registration disabled');
        }
        $form = $this->createForm('register', new User());

        return $this->render('FabricaWebsiteBundle:Splash:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function postRegisterAction(Request $request)
    {
        if (!$this->get('fabrica_core.config')->get('open_registration')) {
            throw $this->createNotFoundException('Registration disabled');
        }

        $user = new User();
        $form = $this->createForm('register', $user);

        if ($form->bind($request)->isValid()) {
            $this->persistEntity($user);
            $this->setFlash('success', $this->trans('notice.success', array(), 'register'));

            return $this->redirect($this->generateUrl('splash_login'));
        }

        $this->setFlash('error', $this->trans('error.form_invalid', array(), 'register'));

        return $this->render('FabricaWebsiteBundle:Splash:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function forgotPasswordAction()
    {
        $form = $this->createForm('email');

        return $this->render('FabricaWebsiteBundle:Splash:forgotPassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function postForgotPasswordAction(Request $request)
    {
        $form = $this->createForm('email');
        $form->bind($request);
        $email = $form->getData();

        try {
            $user  = $this->getRepository('FabricaCoreBundle:User')->findOneByEmail($email);
            $token = $this->getRepository('FabricaCoreBundle:UserForgotPassword')->findOneByUser($user);
            $token->setToken();
            $this->persistEntity($token);

            $this->mail($user, 'FabricaWebsiteBundle:Mail:forgotPassword.mail.twig', array('user' => $user, 'email' => $email, 'token' => $token));
        } catch (NoResultException $e) {}

        $this->setFlash('success', $this->trans('notice.mail_sent', array(), 'forgot_password'));

        return $this->redirect($this->generateUrl('splash_login'));
    }

    public function changePasswordAction($username, $token)
    {
        list($user, $forgotPassword) = $this->validateForgotPasswordToken($username, $token);
        $form                        = $this->createForm('change_password', $user);

        return $this->render('FabricaWebsiteBundle:Splash:changePassword.html.twig', array(
            'form'     => $form->createView(),
            'user'     => $user,
            'username' => $username,
            'token'    => $token
        ));
    }

    public function postChangePasswordAction(Request $request, $username, $token)
    {
        list($user, $forgotPassword) = $this->validateForgotPasswordToken($username, $token);
        $form                        = $this->createForm('change_password', $user);

        $form->bind($request);

        if ($form->isValid()) {
            $this->persistEntity($user);
            $this->setFlash('success', $this->trans('notice.password_changed', array(), 'forgot_password'));

            return $this->redirect($this->generateUrl('splash_login'));
        }

        return $this->render('FabricaWebsiteBundle:Splash:changePassword.html.twig', array(
            'form'     => $form->createView(),
            'user'     => $user,
            'username' => $username,
            'token'    => $token
        ));
    }

    protected function validateForgotPasswordToken($username, $token)
    {
        $user = $this->getRepository('FabricaCoreBundle:User')->findOneByUsername($username);
        if (!$user) {
            throw $this->createNotFoundException('No user with username '.$username);
        }

        $forgotPassword = $this->getRepository('FabricaCoreBundle:UserForgotPassword')->findOneByUser($user);
        try {
            $forgotPassword->validateToken($token);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('This token is invalid', $e);
        }

        return array($user, $forgotPassword);
    }

    public function activateEmailAction($token)
    {
        $email = $this->getRepository('FabricaCoreBundle:Email')->findOneByActivationToken($token);

        if (!$email) {
            throw $this->createNotFoundException(sprintf('Token "%s" not found', $token));
        }

        $email->validateActivationToken($token);
        $this->flush();

        return $this->render('FabricaWebsiteBundle:Splash:activateEmail.html.twig', array(
            'email' => $email,
        ));
    }
}
