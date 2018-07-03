<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Section;
use App\Entity\Allocation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionAllocationController extends Controller
{
    /**
     * @Route("/section/allocation", name="section_allocation")
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idSection = $request->query->get('id');
        $section = $em->getRepository('App:Section')->find($idSection);
        $sectionSchedule = $section->getSchedule();
        $classrooms = $em->getRepository('App:Classroom')->findAll();
        $allocations = $em->getRepository('App:Allocation')->findAll();

        $arrayClassroomSchedule = [];

        foreach ($allocations as $allocation) {
            if (!$allocation instanceof \App\Entity\Allocation) {

            }
            $arrayClassroomSchedule = $allocation->getClassroom();
            $arrayClassroomSchedule = $allocation->getSection()->getSchedule();

        }

        return $this->render(
            'section_allocation/index.html.twig',
            [
                'controller_name' => 'SectionAllocationController',
                'section' => $section,
                'section_schedule' => $sectionSchedule,
                'classrooms' => $classrooms,
            ]
        );
    }

    private function filterByClassroomTaken(Classroom $classrooms, Schedule $schedule, Allocation $allocations)
    {
        $weekdayBlockAbv = $schedule->getAbv();

        return $weekdayBlockAbv;
    }
}
