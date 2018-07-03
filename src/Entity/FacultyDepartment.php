<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FacultyDepartmentRepository")
 */
class FacultyDepartment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="facultyDepartments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faculty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="facultyDepartments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Career", mappedBy="faculty_department")
     */
    private $careers;

    public function __construct()
    {
        $this->careers = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getFacultyDepartmentName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getFacultyDepartmentName()
    {
        $department = $this->getDepartment();
        $faculty = $this->getFaculty();
        $fd = $faculty." - ".$department;

        return $fd;

    }

    public function getFacultyAbvDepartmentName()
    {
        $department = $this->getDepartment();
        $faculty = $this->getFaculty()->getAbbreviation();
        $fd = $faculty." - ".$department;

        return $fd;

    }

    /**
     * @return Collection|Career[]
     */
    public function getCareers(): Collection
    {
        return $this->careers;
    }

    public function addCareer(Career $career): self
    {
        if (!$this->careers->contains($career)) {
            $this->careers[] = $career;
            $career->setFacultyDepartment($this);
        }

        return $this;
    }

    public function removeCareer(Career $career): self
    {
        if ($this->careers->contains($career)) {
            $this->careers->removeElement($career);
            // set the owning side to null (unless already changed)
            if ($career->getFacultyDepartment() === $this) {
                $career->setFacultyDepartment(null);
            }
        }

        return $this;
    }
}
