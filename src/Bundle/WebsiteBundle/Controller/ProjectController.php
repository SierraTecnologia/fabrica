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

use Fabrica\Models\Code\Project;
use Fabrica\Models\Code\ProjectGitAccess;
use Fabrica\Models\Code\UserRoleProject;
use Fabrica\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Fabrica\Bundle\CoreBundle\EventDispatcher\FabricaEvents;
use Fabrica\Bundle\CoreBundle\Job\DeleteReferenceJob;
use Fabrica\Component\Pagination\Adapter\GitLogAdapter;
use Fabrica\Component\Pagination\Pager;
use Fabrica\Tools\Programs\Git\Blob;
use Fabrica\Tools\Programs\Git\Reference;
use Fabrica\Tools\Programs\Git\Tree;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function listAction()
    {
        $this->assertGranted('IS_AUTHENTICATED_REMEMBERED');

        $pool = $this->get('fabrica_core.git.repository_pool');

        if ($this->isGranted('ROLE_ADMIN')) {
            $projects = $this->getRepository('FabricaCoreBundle:Project')->findAll();
        } else {
            $projects = $this->getRepository('FabricaCoreBundle:Project')->findByUser($this->getUser());
        }

        return $this->render(
            'FabricaWebsiteBundle:Project:list.html.twig', array(
            'projects' => $projects
            )
        );
    }

    public function createAction(Request $request)
    {
        $this->assertGranted('ROLE_PROJECT_CREATE');

        $user    = $this->getUser();
        $project = new Project();
        $form    = $this->createForm('project', $project);

        if ('GET' === $request->getMethod()) {
            return $this->render(
                'FabricaWebsiteBundle:Project:create.html.twig', array(
                'form' => $form->createView()
                )
            );
        }

        $form->bind($request);

        if (!$form->isValid()) {
            $this->setFlash('error', $this->trans('error.form_invalid', array(), 'register'));

            return $this->render(
                'FabricaWebsiteBundle:Project:create.html.twig', array(
                'form' => $form->createView()
                )
            );
        }

        $role    = $this->getRepository('FabricaCoreBundle:Role')->findOneByName('Lead developer');
        $project->getUserRoles()->add(new UserRoleProject($user, $project, $role));

        $this->dispatch(FabricaEvents::PROJECT_CREATE, new ProjectEvent($project));
        $this->persistEntity($project);
        $this->setFlash('success', $this->trans('notice.project_created', array(), 'project'));

        return $this->redirect($this->generateUrl('project_newsfeed', array('slug' => $project->getSlug())));
    }

    public function newsfeedAction(Request $request, $slug)
    {
        $project = $this->getProject($slug);
        $branch  = $request->query->get('branch');
        $page    = $request->query->get('page', 1);

        if ($project->isEmpty()) {
            return $this->render(
                'FabricaWebsiteBundle:Project:empty.html.twig', array(
                'project'    => $project
                )
            );
        }

        return $this->render(
            'FabricaWebsiteBundle:Project:newsfeed.html.twig', array(
            'project'  => $project,
            'messages' => $this->getRepository('FabricaCoreBundle:Message')->getPagerForProject($project, $branch)->setPage($page),
            'branch'   => $branch,
            )
        );
    }

    public function historyAction(Request $request, $slug)
    {
        $branch     = $request->query->get('branch', null);
        $project    = $this->getProject($slug);
        $repository = $project->getRepository();
        $log        = $repository->getLog($branch);

        $log
            ->setOffset($request->query->get('offset', 0))
            ->setLimit($request->query->get('limit', 25));

        $template = $request->isXmlHttpRequest() ?
            'FabricaWebsiteBundle:Project:history_ajax.html.twig' :
            'FabricaWebsiteBundle:Project:history.html.twig'
        ;

        return $this->render(
            $template, array(
            'project'  => $project,
            'branch'   => $branch,
            'log'      => $log,
            )
        );
    }

    /**
     * Displays a commit.
     */
    public function commitAction($slug, $hash)
    {
        $project    = $this->getProject($slug);
        $commit     = $project->getRepository()->getCommit($hash);

        return $this->render(
            'FabricaWebsiteBundle:Project:commit.html.twig', array(
            'project'    => $project,
            'reference'  => $project->getDefaultBranch(),
            'commit'     => $commit
            )
        );
    }

    /**
     * @var string $revision Can be a branch name or a commit hash
     */
    public function treeAction($slug, $revision, $path)
    {
        $project    = $this->getProject($slug);
        $repository = $project->getRepository();
        $refs       = $repository->getReferences();

        if ($refs->hasBranch($revision)) {
            $revision = $refs->getBranch($revision);
        } else {
            $revision = $repository->getRevision($revision);
        }

        $commit = $revision->getCommit();

        $tree = $commit->getTree();
        if (strlen($path) > 0 && '/' === substr($path, 0, 1)) {
            $path = substr($path, 1);
        }

        try {
            $element = $tree->resolvePath($path);
        } catch (\InvalidArgumentException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        $parameters = array(
            'project'  => $project,
            'revision' => $revision,
            'path'     => $path,
        );

        if ($element instanceof Blob) {
            $parameters['blob'] = $element;
            $tpl = 'FabricaWebsiteBundle:Project:blob.html.twig';
        } elseif ($element instanceof Tree) {
            $parameters['tree'] = $element;
            $tpl = 'FabricaWebsiteBundle:Project:tree.html.twig';
        }

        return $this->render($tpl, $parameters);
    }

    public function branchesAction(Request $request, $slug)
    {
        $project   = $this->getProject($slug);
        $reference = $request->query->get('reference', $project->getDefaultBranch());

        return $this->render(
            'FabricaWebsiteBundle:Project:branches.html.twig', array(
            'project'   => $project,
            'reference' => $reference,
            )
        );
    }

    public function branchDeleteAction(Request $request, $slug, $branch)
    {
        $project   = $this->getProject($slug);
        $branch    = $project->getRepository()->getReferences()->getBranch($branch);
        $user      = $this->getUser();

        $this->assertGranted('GIT_DELETE', array($project, $branch->getFullname()));

        $job = DeleteReferenceJob::create($project, $branch, $user);
        $this->get('fabrica.job_manager')->delegate($job);

        return $this->redirect(
            $this->generateUrl(
                'job_wait', array(
                'id'       => $job->getId(),
                'pending'  => $this->trans('notice.branch_deleting', array('%branch%' => $branch->getName()), 'project_branches'),
                'finished' => $this->trans('notice.branch_deleted', array('%branch%' => $branch->getName()), 'project_branches'),
                'redirect' => $this->generateUrl('project_branches', array('slug' => $slug))
                )
            )
        );
    }

    public function tagsAction($slug)
    {
        $project    = $this->getProject($slug);
        $tags       = $project->getRepository()->getReferences()->getTags();

        usort(
            $tags, function ($left, $right) {
                return $left->getCommit()->getAuthorDate() < $right->getCommit()->getAuthorDate();
            }
        );

        return $this->render(
            'FabricaWebsiteBundle:Project:tags.html.twig', array(
            'project' => $project,
            'tags'    => $tags,
            )
        );
    }

    /**
     * Displays tree history.
     */
    public function treeHistoryAction(Request $request, $slug, $revision, $path)
    {
        $project    = $this->getProject($slug);
        $repository = $project->getRepository();
        $refs       = $repository->getReferences();

        if ($refs->hasBranch($revision)) {
            $revision = $refs->getBranch($revision);
        } else {
            $revision = $repository->getRevision($revision);
        }

        $log        = $revision->getLog($path);

        $log
            ->setOffset($request->query->get('offset', 0))
            ->setLimit($request->query->get('limit', 25));

        $template = $request->isXmlHttpRequest() ?
            'FabricaWebsiteBundle:Project:history_ajax.html.twig' :
            'FabricaWebsiteBundle:Project:treeHistory.html.twig'
        ;

        return $this->render(
            $template, array(
            'path'     => $path,
            'project'  => $project,
            'revision' => $revision,
            'log'      => $log,
            )
        );
    }

    public function blameAction(Request $request, $slug, $path, $revision)
    {
        $project = $this->getProject($slug);
        $repository = $project->getRepository();

        $revision = $repository->getRevision($revision);
        $resolved = $revision->getCommit()->getTree()->resolvePath($path);

        if (!$resolved instanceof Blob || $resolved->isBinary()) {
            throw $this->createNotFoundException('Cannot blame a tree or binary');
        }

        $blame = $repository->getBlame($revision, $path);

        return $this->render(
            'FabricaWebsiteBundle:Project:blame.html.twig', array(
            'project'       => $project,
            'blame'         => $blame,
            'revision'     => $revision,
            'path'          => $path,
            'path_exploded' => explode('/', $path)
            )
        );
    }

    public function compareAction($slug, $revision)
    {
        $project = $this->getProject($slug);
        $log     = $project->getRepository()->getLog($revision);

        return $this->render(
            'FabricaWebsiteBundle:Project:compare.html.twig', array(
            'project'   => $project,
            'revision' => $revision,
            'log'       => $log,
            'diff'      => $log->getDiff()
            )
        );
    }

    public function permissionsAction($slug)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $roleForm      = $this->createForm('project_role', null, array('usedUsers' => $project->getUsers()));
        $gitAccessForm = $this->createForm('project_git_access');

        return $this->render(
            'FabricaWebsiteBundle:Project:permissions.html.twig', array(
            'project'       => $project,
            'roleForm'      => $roleForm->createView(),
            'gitAccessForm' => $gitAccessForm->createView(),
            'token'         => $this->createToken('project_permissions')
            )
        );
    }

    public function postPermissionsCreateRoleAction(Request $request, $slug)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $role          = new UserRoleProject(null, $project);
        $roleForm      = $this->createForm('project_role', $role, array('usedUsers' => $project->getUsers()));
        $gitAccessForm = $this->createForm('project_git_access');

        if ($roleForm->bind($request)->isValid()) {
            $this->persistEntity($role);
            $this->setFlash('success', $this->trans('notice.role_created', array(), 'project_permissions'));

            return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
        }

        return $this->render(
            'FabricaWebsiteBundle:Project:permissions.html.twig', array(
            'project'       => $project,
            'roleForm'      => $roleForm->createView(),
            'gitAccessForm' => $gitAccessForm->createView(),
            'token'         => $this->createToken('project_permissions')
            )
        );
    }

    public function postPermissionsDeleteRoleAction(Request $request, $slug, $id)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $role = $this->getRepository('FabricaCoreBundle:UserRoleProject')->find($id);

        if ($role->getProject() !== $project) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isTokenValid('project_permissions', $request->query->get('_token'))) {
            $this->setFlash('error', $this->trans('error.token_invalid', array(), 'project_permissions'));

            return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
        }

        $em = $this->get('doctrine')->getManager();
        $em->remove($role);
        $em->flush();
        $this->setFlash('success', $this->trans('notice.role_deleted', array(), 'project_permissions'));

        return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
    }

    public function postPermissionsCreateGitAccessAction(Request $request, $slug)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $gitAccess     = new ProjectGitAccess($project);
        $roleForm      = $this->createForm('project_role', null, array('usedUsers' => $project->getUsers()));
        $gitAccessForm = $this->createForm('project_git_access', $gitAccess);

        if ($gitAccessForm->bind($request)->isValid()) {
            $this->persistEntity($gitAccess);
            $this->setFlash('success', $this->trans('notice.git_access_created', array(), 'project_permissions'));

            return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
        }

        return $this->render(
            'FabricaWebsiteBundle:Project:permissions.html.twig', array(
            'project'       => $project,
            'roleForm'      => $roleForm->createView(),
            'gitAccessForm' => $gitAccessForm->createView()
            )
        );
    }

    public function postPermissionsDeleteGitAccessAction(Request $request, $slug, $id)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $role    = $this->getRepository('FabricaCoreBundle:ProjectGitAccess')->find($id);

        if ($role->getProject()->getSlug() !== $project->getSlug()) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isTokenValid('project_permissions', $request->query->get('_token'))) {
            $this->setFlash('error', $this->trans('error.token_invalid', array(), 'project_permissions'));

            return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
        }

        $em = $this->get('doctrine')->getManager();
        $em->remove($role);
        $em->flush();

        $this->setFlash('success', $this->trans('notice.git_access_deleted', array(), 'project_permissions'));

        return $this->redirect($this->generateUrl('project_permissions', array('slug' => $slug)));
    }

    public function adminAction(Request $request, $slug)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        $viewProject = clone $project;
        $form        = $this->createForm('project', $project, array('action' => 'edit'));

        if ('POST' === $request->getMethod() && $form->bind($request)->isValid()) {
            $this->flush();
            $this->setFlash('success', $this->trans('notice.information_saved', array(), 'project_admin'));

            return $this->redirect($this->generateUrl('project_admin', array('slug' => $slug)));
        }

        return $this->render(
            'FabricaWebsiteBundle:Project:admin.html.twig', array(
            'form'       => $form->createView(),
            'project'    => $viewProject
            )
        );
    }

    public function deleteAction(Request $request, $slug)
    {
        $this->assertGranted('PROJECT_ADMIN', $project = $this->getProject($slug));

        if (!$this->isTokenValid('project_delete', $request->query->get('_token'))) {
            $this->setFlash('error', $this->trans('error.token_invalid', array(), 'project_permissions'));

            return $this->redirect($this->generateUrl('project_admin', array('slug' => $slug)));
        }

        $this->dispatch(FabricaEvents::PROJECT_DELETE, new ProjectEvent($project));
        $this->removeEntity($project);

        $this->setFlash('success', $this->trans('notice.deleted', array(), 'project_admin'));

        return $this->redirect($this->generateUrl('project_list'));
    }

    /**
     * @return Project
     */
    protected function getProject($slug)
    {
        $user = $this->getUser();

        $project = $this->getDoctrine()->getRepository('FabricaCoreBundle:Project')->findOneBySlug($slug);
        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Project with slug "%s" not found', $slug));
        }

        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('PROJECT_READ', $project)) {
            throw $this->createAccessDeniedException('You are not contributor of the project');
        }

        return $project;
    }
}
