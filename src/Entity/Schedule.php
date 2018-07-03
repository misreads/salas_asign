<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weekday", inversedBy="weekdays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $weekday;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Block", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $block;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="schedule")
     */
    private $sections;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getBlockWeekday();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWeekday(): ?Weekday
    {
        return $this->weekday;
    }

    public function setWeekday(?Weekday $weekday): self
    {
        $this->weekday = $weekday;

        return $this;
    }

    public function getBlock(): ?Block
    {
        return $this->block;
    }

    public function setBlock(?Block $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getBlockWeekday() {
        $block = $this->getBlock()->getId();
        $weekday = $this->getWeekday()->getAbbreviation();
        $block_schedule = $this->getBlock()->getBlockTime();
        $bw = $weekday.$block."  | ".$block_schedule." |";

        return $bw;
    }

    public function getAbv() {
        $block = $this->getBlock()->getId();
        $weekday = $this->getWeekday()->getAbbreviation();
        $wb = $weekday.$block;

        return $wb;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setSchedule($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getSchedule() === $this) {
                $section->setSchedule(null);
            }
        }

        return $this;
    }

}
