<?php

namespace App\Twig;


use App\Entity\Section;

class EasyAdminExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'filter_admin_actions',
                [$this, 'filterActions']
            )
        ];
    }

    public function filterActions(array $itemActions, $item)
    {
        if ($item instanceof Section && $item->getIsTaken() === true) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }
}