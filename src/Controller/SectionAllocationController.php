<?php

namespace App\Controller;

use App\Entity\Allocation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionAllocationController extends Controller
{
    /**
     * @Route("/section/allocation", name="section_allocation")
     * @Method({"GET"})
     */
    public function showAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();

        $idSection = $request->query->get('id');
        $section = $em->getRepository('App:Section')->find($idSection);
        $sectionSchedule = $section->getSchedule();
        $classrooms = $em->getRepository('App:Classroom')->findAll();
        $allocations = $em->getRepository('App:Allocation')->findAll();


        $currentSectionSchedule = $section->getSchedule()->getAbv();
        $currentSectionClassSize = $section->getClassSize();
        $classroomAvailableAll = [];
        $classroomNotAvailable = [];
        $classroomAvailableSorted = [];

        foreach ($allocations as $allocation) {
            if ($allocation->getSection()->getSchedule()->getAbv() === $currentSectionSchedule) {
                $classroomNotAvailable[] = $allocation->getClassroom();
            }
        }


        foreach ($classrooms as $classroom) {
            $isAvailable = true;
            foreach ($classroomNotAvailable as $cna) {
                if ($classroom->getId() === $cna->getId()) {
                    $isAvailable = false;
                }
            }
            if ($isAvailable) {
                $classroomAvailableAll[] = $classroom;
            }
        }

        foreach ($classroomAvailableAll as $classroom) {
            if ($classroom->getClassSize() >= $currentSectionClassSize)
            {
                $classroomAvailableSorted[] = $classroom;
            }
        }

        usort($classroomAvailableSorted,function ($a, $b){
            if ($a->getClasssize() == $b->getClasssize()) {
                return 0;
            }
            return ($a->getClasssize() < $b->getClasssize()) ? -1 : 1;
        });

        return $this->render(
            'section_allocation/index.html.twig',
            [
                'controller_name' => 'SectionAllocationController',
                'section' => $section,
                'section_schedule' => $sectionSchedule,
                'classrooms' => $classroomAvailableSorted,
            ]
        );
    }

    /**
     * @Route("/section/allocation", name="new_allocation" , defaults={"_format":"json"})
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
            'entity' => 'SectionCustom',
        ));

        return JsonResponse::create([
            'url' => $url
        ]);
    }

}
