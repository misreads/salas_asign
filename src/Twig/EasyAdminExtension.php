<?php

namespace App\Twig;


use App\Entity\Allocation;
use App\Entity\Career;
use App\Entity\Classroom;
use App\Entity\FacultyDepartment;
use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\Subject;

class EasyAdminExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'filter_admin_actions_section',
                [$this, 'filterActionsSection']
            ),
            new \Twig_SimpleFilter(
                'filter_admin_actions_career',
                [$this, 'filterActionsCareer']
            ),
            new \Twig_SimpleFilter(
                'filter_admin_actions_professor',
                [$this, 'filterActionsProfessor']
            ),
            new \Twig_SimpleFilter(
                'filter_admin_actions_subject',
                [$this, 'filterActionsSubject']
            ),
            new \Twig_SimpleFilter(
                'filter_admin_actions_classroom',
                [$this, 'filterActionsClassroom']
            ),new \Twig_SimpleFilter(
                'filter_admin_actions_fd',
                [$this, 'filterActionsFD']
            )
        ];
    }

    public function filterActionsSection(array $itemActions, $item)
    {
        if ($item instanceof Section && $item->getIsTaken() === true) {
            unset($itemActions['delete']);
            unset($itemActions['edit']);
        }
        return $itemActions;
    }

    public function filterActionsCareer(array $itemActions, $item)
    {
        if ($item instanceof Career && count($item->getSubjects()) > 0) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }
    public function filterActionsProfessor(array $itemActions, $item)
    {
        if ($item instanceof Professor && count($item->getSections()) > 0) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }
    public function filterActionsSubject(array $itemActions, $item)
    {
        if ($item instanceof Subject && count($item->getSections()) > 0) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }

    public function filterActionsClassroom(array $itemActions, $item)
    {
        if ($item instanceof Classroom && count($item->getAllocations()) > 0) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }

    public function filterActionsFD(array $itemActions, $item)
    {
        if ($item instanceof FacultyDepartment && count($item->getCareers()) > 0) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }
}