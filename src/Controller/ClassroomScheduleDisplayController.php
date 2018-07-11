<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomScheduleDisplayController extends Controller
{
    /**
     * @Route("/classroom/schedule/display", name="classroom_schedule_display")
     */
    public function showAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $idClassroom = $request->query->get('id');

        $classroom = $em->getRepository('App:Classroom')->find($idClassroom);
        $blocks = $em->getRepository('App:Block')->findAll();
        $weekdays = $em->getRepository('App:Weekday')->findAll();
        $allocations = $em->getRepository('App:Allocation')->findAll();

        $allocationByClassroom = [];
        $l = array_fill(1,9," ");;
        $m = array_fill(1,9," ");;
        $w = array_fill(1,9," ");;
        $j = array_fill(1,9," ");;
        $v = array_fill(1,9," ");;
        $s = array_fill(1,9," ");;
        $blockArray = [];

        $count = 1;
        foreach ($blocks as $block)
        {
            $blockArray[$count] = $block->getBlockTime();
            $count++;
        }

        foreach ($allocations as $allocation)
        {
            if ($allocation->getClassroom()->getId() === $classroom->getId())
            {
                $allocationByClassroom[] = $allocation;
            }
        }



        foreach ($allocationByClassroom as $alloc)
        {
            if ($alloc->getSection()->getSchedule()->getAbv())
            {
                $abv = $alloc->getSection()->getSchedule()->getAbv();
                $dayAbv = $abv[0];
                $index = $abv[1];
                $allocInfo = $alloc->getSection()->getName() ." - ". $alloc->getSection()->getProfessor();

                switch ($dayAbv) {
                    case "L":
                        $l[$index] = $allocInfo;
                        break;
                    case "M":
                        $m[$index] = $allocInfo;
                        break;
                    case "W":
                        $w[$index] = $allocInfo;
                        break;
                    case "J":
                        $j[$index] = $allocInfo;
                        break;
                    case "V":
                        $v[$index] = $allocInfo;
                        break;
                    case "S":
                        $s[$index] = $allocInfo;
                        break;
                }
            }
        }

        $dataSchedule = [];

        for ($i = 1; $i <= 9; $i++)
        {
            $dataSchedule[$i] = array(
                'block' => $blockArray[$i],
                'lunes' => $l[$i],
                'martes' => $m[$i],
                'miercoles' => $w[$i],
                'jueves' => $j[$i],
                'viernes' => $v[$i],
                'sabado' => $s[$i],

            );
        }

        return $this->render('classroom_schedule_display/index.html.twig', [
            'controller_name' => 'ClassroomScheduleDisplayController',
            'classroom' => $classroom,
            'weekdays' => $weekdays,
            'data_schedule' => $dataSchedule,
        ]);
    }
}
