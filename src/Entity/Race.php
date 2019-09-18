<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 */
class Race
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $location;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $raceDateStart;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $raceDateEnd;

    /**
     * @var \App\Entity\RacePrediction
     * @ORM\OneToMany(targetEntity="App\Entity\RacePrediction", mappedBy="race")
     */
    private $racePredictions;

    public function __construct()
    {
        $this->racePredictions = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getRaceDateStart(): ?string
    {
        return $this->raceDateStart;
    }

    /**
     * @param string $raceDateStart
     */
    public function setRaceDateStart(?string $raceDateStart): void
    {
        $this->raceDateStart = $raceDateStart;
    }

    /**
     * @return string
     */
    public function getRaceDateEnd(): ?string
    {
        return $this->raceDateEnd;
    }

    /**
     * @param string $raceDateEnd
     */
    public function setRaceDateEnd(?string $raceDateEnd): void
    {
        $this->raceDateEnd = $raceDateEnd;
    }

    public function getId(): ?int
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

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return \App\Entity\RacePrediction
     */
    public function getRacePredictions(): \App\Entity\RacePrediction
    {
        return $this->racePredictions;
    }

    public function addRacePrediction(RacePrediction $racePredictions): self
    {
        if (!$this->racePredictions->contains($racePredictions)) {
            $this->racePredictions[] = $racePredictions;
            $racePredictions->setFastestDriverInQuali($this);
        }

        return $this;
    }

    public function removeRacePrediction(RacePrediction $racePredictions): self
    {
        if ($this->racePredictions->contains($racePredictions)) {
            $this->racePredictions->removeElement($racePredictions);
            // set the owning side to null (unless already changed)
            if ($racePredictions->getFastestDriverInQuali() === $this) {
                $racePredictions->setFastestDriverInQuali(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isAvailable()
    {
        $isAvailable = false;

        $startDate =  new \DateTime($this->getRaceDateStart());
        $endDate =  new \DateTime($this->getRaceDateEnd());
        $currentDate = new \DateTime('now');

        $startDate =  $startDate->format("d-m-Y");
        $endDate =  $endDate->format("d-m-Y");
        $currentDate = $currentDate->format("d-m-Y");

        if ($startDate < $currentDate && $endDate > $currentDate)
        {
            $isAvailable = true;
        }

        return $isAvailable;

    }

}
