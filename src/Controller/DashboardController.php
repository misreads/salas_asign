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
     * @Route("/salas_asign/dashboard", name="dashboard")
     */
    public function index()
    {
        $university = 'Universidad de Santiago de Chile';
        $em = $this->getDoctrine()->getManager();
        $allocations = $em->getRepository('App:Allocation')->findAll();
        $sections = $em->getRepository('App:Section')->findAll();

        $countAllocation = count($allocations);
        $countSections = count($sections);
        $countNoAllocSection = $countSections - $countAllocation;

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'university' => $university,
            'allocations' => $countAllocation,
            'sections' => $countSections,
            'noalloc' => $countNoAllocSection,
        ]);
    }


}
