<?php

namespace App\Controller\EasyAdminBundle;

use App\Entity\Section;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;


class SectionController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        $entity->setIsTaken(false);
    }


}