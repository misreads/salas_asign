<?php

namespace App\Twig;


use App\Entity\Career;
use App\Entity\Professor;
use App\Entity\Section;

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
            unset($itemActions['edit']);
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
}