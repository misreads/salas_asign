<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Section;
use App\Entity\Allocation;
use App\Repository\AllocationRepository;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomAllocationController extends Controller
{
    /**
     * @Route("/classroom/allocation", name="classroom_allocation")
     */
    public function index(ClassroomRepository $classroomRepository): Response
    {
        return $this->render('classroom_allocation/index.html.twig', ['classrooms' => $classroomRepository->findAll()]);
    }
}
