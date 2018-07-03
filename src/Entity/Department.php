<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FacultyDepartment", mappedBy="department")
     */
    private $facultyDepartments;

    public function __construct()
    {
        $this->facultyDepartments = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        if (null == $this->updatedAt) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     **/
    public function updateModifiedDatetime(): ?\DateTimeInterface
    {
        $this->setUpdatedAt(new \DateTime());
        return $this;
    }

    /**
     * @return Collection|FacultyDepartment[]
     */
    public function getFacultyDepartments(): Collection
    {
        return $this->facultyDepartments;
    }

    public function addFacultyDepartment(FacultyDepartment $facultyDepartment): self
    {
        if (!$this->facultyDepartments->contains($facultyDepartment)) {
            $this->facultyDepartments[] = $facultyDepartment;
            $facultyDepartment->setDepartment($this);
        }

        return $this;
    }

    public function removeFacultyDepartment(FacultyDepartment $facultyDepartment): self
    {
        if ($this->facultyDepartments->contains($facultyDepartment)) {
            $this->facultyDepartments->removeElement($facultyDepartment);
            // set the owning side to null (unless already changed)
            if ($facultyDepartment->getDepartment() === $this) {
                $facultyDepartment->setDepartment(null);
            }
        }

        return $this;
    }
}
