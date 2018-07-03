<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeekdayRepository")
 */
class Weekday
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
    private $day;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abbreviation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="weekday")
     */
    private $weekdays;

    public function __construct()
    {
        $this->weekdays = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getDay();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return Collection|Schedule[]
     */
    public function getWeekdays(): Collection
    {
        return $this->weekdays;
    }

    public function addWeekday(Schedule $weekday): self
    {
        if (!$this->weekdays->contains($weekday)) {
            $this->weekdays[] = $weekday;
            $weekday->setWeekday($this);
        }

        return $this;
    }

    public function removeWeekday(Schedule $weekday): self
    {
        if ($this->weekdays->contains($weekday)) {
            $this->weekdays->removeElement($weekday);
            // set the owning side to null (unless already changed)
            if ($weekday->getWeekday() === $this) {
                $weekday->setWeekday(null);
            }
        }

        return $this;
    }
}
