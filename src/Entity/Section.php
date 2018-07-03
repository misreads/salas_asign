<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $class_size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Schedule", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schedule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professor", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $professor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Allocation", mappedBy="section")
     */
    private $allocations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTaken;

    public function __construct()
    {
        $this->allocations = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        if (null == $this->updatedAt) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function __toString()
    {
        return (string) $this->getSectionInfo();
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

    public function getClassSize(): ?int
    {
        return $this->class_size;
    }

    public function setClassSize(int $class_size): self
    {
        $this->class_size = $class_size;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;

        return $this;
    }

    public function getSectionInfo() {
        $sectionCode = $this->getCode();
        $sectionSubject = $this->getSubject()->getName();
        $sectionSchedule = $this->getSchedule()->getBlockWeekday();

        $data = $sectionSubject." | ".$sectionSchedule." ".$sectionCode;

        return $data;
    }

    public function getFD() {
        $fd = $this->getSubject()->getCareer()->getFacultyDepartment()->getFacultyAbvDepartmentName();
        return $fd;
    }

    /**
     * @return Collection|Allocation[]
     */
    public function getAllocations(): Collection
    {
        return $this->allocations;
    }

    public function addAllocation(Allocation $allocation): self
    {
        if (!$this->allocations->contains($allocation)) {
            $this->allocations[] = $allocation;
            $allocation->setSection($this);
        }

        return $this;
    }

    public function removeAllocation(Allocation $allocation): self
    {
        if ($this->allocations->contains($allocation)) {
            $this->allocations->removeElement($allocation);
            // set the owning side to null (unless already changed)
            if ($allocation->getSection() === $this) {
                $allocation->setSection(null);
            }
        }

        return $this;
    }

    public function getIsTaken(): ?bool
    {
        return $this->isTaken;
    }

    public function setIsTaken(bool $isTaken): self
    {
        $this->isTaken = $isTaken;

        return $this;
    }
}
