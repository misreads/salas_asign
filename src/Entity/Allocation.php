<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllocationRepository")
 */
class Allocation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="allocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classroom", inversedBy="allocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;

    public function __toString()
    {
        return (string) $this->getSectionClassroom();
    }
    public function getId()
    {
        return $this->id;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getSectionClassroom() {
        $classroomNumber = $this->getClassroom()->getNumber();
        $sectionName = $this->getSection()->getName();
        $sectionSchedule = $this->getSection()->getSchedule()->getBlockWeekday();

        $data = "Sala: ".$classroomNumber." ".$sectionName." ".$sectionSchedule;

        return $data;

    }
}
