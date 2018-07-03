<?php

namespace App\Controller;


use App\Entity\Allocation;
use App\Entity\Schedule;
use App\Entity\Subject;
use App\Entity\Section;
use App\Entity\Classroom;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }


}
