<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CareerRepository")
 */
class Career
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
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FacultyDepartment", inversedBy="careers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faculty_department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subject", mappedBy="career")
     */
    private $subjects;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getFacultyDepartment(): ?FacultyDepartment
    {
        return $this->faculty_department;
    }

    public function setFacultyDepartment(?FacultyDepartment $faculty_department): self
    {
        $this->faculty_department = $faculty_department;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setCareer($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getCareer() === $this) {
                $subject->setCareer(null);
            }
        }

        return $this;
    }
}
