<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function persistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }

    protected function removeAllocationEntity($entity)
    {
        $entity->getSection()->setIsTaken(false);
        $this->em->remove($entity);
        $this->em->flush();
    }

    private function checkPermissions()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $easyAdmin = $this->request->attributes->get('easyadmin');

        $action = $this->request->query->get('action');

        $perms = $easyAdmin['entity'][$action]['require_permission'];
        $roles = $this->get('security.context')->getToken()->getUser()->getRoles();

        foreach ($roles as $key => $value)
        {

            $permessi_file = $value;

            if (in_array($permessi_file, $perms)) {

                $requiredPermission = $permessi_file;

            }
            else
            {
                $view = $easyAdmin['view'];
                $entity = $easyAdmin['entity']['name'];
                $requiredPermission = 'ROLE_'.strtoupper($view).'_'.strtoupper($entity);
                # Or any other default strategy
            }
            $this->denyAccessUnlessGranted(
                $requiredPermission, null, $requiredPermission.' permission required'
            );
        }

    }

    public function indexAction(Request $request)
    {
        $this->initialize($request);

        if (null === $request->query->get('entity')) {
            return $this->redirectToBackendHomepage();
        }

        $action = $request->query->get('action', 'list');
        if (!$this->isActionAllowed($action)) {
            throw new ForbiddenActionException(array('action' => $action, 'entity_name' => $this->entity['name']));
        }
        $this->checkPermissions();

        return $this->executeDynamicMethod($action.'<EntityName>Action');
    }

}