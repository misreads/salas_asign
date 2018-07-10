<?php

namespace App\Controller;

use App\Entity\Allocation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomAllocationController extends Controller
{
    /**
     * @Route("/classroom/allocation", name="classroom_allocation")
     * @Method({"GET"})
     */
    public function showAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $idClassroom = $request->query->get('id');
        $classroom = $em->getRepository('App:Classroom')->find($idClassroom);
        $sections = $em->getRepository('App:Section')->findAll();
        $allocations = $em->getRepository('App:Allocation')->findAll();

        $classroomAllocation = $classroom->getAllocations();
        $classroomClassSize = $classroom->getClassSize();
        $scheduleNotAvailable = [];
        $sectionAvailable = [];
        $sectionAvailableSorted = [];
        $sectionAvailableSortedFinal = [];

        foreach ($classroomAllocation as $ca)
        {
            $scheduleNotAvailable[] = $ca->getSection()->getSchedule()->getAbv();
        }

        foreach ($sections as $section) {
            $isAvailable = true;
            foreach ($scheduleNotAvailable as $sna) {
                if ($section->getSchedule()->getAbv() === $sna) {
                    $isAvailable = false;
                }
            }
            if ($isAvailable) {
                $sectionAvailable[] = $section;
            }
        }

        foreach ($sectionAvailable as $sa) {
            if ($sa->getClassSize() <= $classroomClassSize )
            {
                $sectionAvailableSorted[] = $sa;
            }
        }

        foreach ($sectionAvailableSorted as $sas) {
            if ($sas->getIsTaken() === false )
            {
                $sectionAvailableSortedFinal[] = $sas;
            }
        }

        usort($sectionAvailableSortedFinal,function ($a, $b){
            if ($a->getClasssize() == $b->getClasssize()) {
                return 0;
            }
            return ($a->getClasssize() > $b->getClasssize()) ? -1 : 1;
        });

        return $this->render(
            'classroom_allocation/index.html.twig',
            [
                'controller_name' => 'ClassroomAllocationController',
                'sections' => $sectionAvailableSortedFinal,
                'classroom' => $classroom,
            ]
        );
    }

    /**
     * @Route("/classroom/allocation", name="new_allocation" , defaults={"_format":"json"})
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $allocation = new Allocation();

        $sectionId = $request->request->get('section');
        $classroomId = $request->request->get('classroom');

        $section = $em->getRepository('App:Section')->find($sectionId);
        $classroom = $em->getRepository('App:Classroom')->find($classroomId);

        $section->setIsTaken(true);

        $allocation->setSection($section);
        $allocation->setClassroom($classroom);

        $em->persist($allocation);
        $em->persist($section);
        $em->flush();


        $url = $this->generateUrl('easyadmin', array(
            'action' => 'list',
            'entity' => 'ClassroomCustom',
        ));

        return JsonResponse::create([
            'url' => $url
        ]);
    }

}
