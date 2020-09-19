<?php

namespace Fabrica\Bundle\JobBundle\Controller;

use Fabrica\Bundle\WebsiteBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JobController extends Controller
{
    public function waitAction(Request $request, $id)
    {
        $status = $this->get('fabrica.job_manager')->getStatus($id);

        $finished = $request->query->get('finished');
        $redirect = $request->query->get('redirect');

        if ($status['finished']) {
            $this->setFlash('success', $finished);

            return $this->redirect($redirect);
        }

        return $this->render(
            'FabricaJobBundle:Job:wait.html.twig', array(
            'id' => $id
            )
        );
    }

    public function statusAction($id)
    {
        return $this->json($this->get('fabrica.job_manager')->getStatus($id));
    }
}
