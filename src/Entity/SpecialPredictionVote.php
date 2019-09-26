<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialPredictionVoteRepository")
 */
class SpecialPredictionVote
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isHappening;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SpecialPrediction")
     */
    private $specialPrediction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsHappening(): ?bool
    {
        return $this->isHappening;
    }

    public function setIsHappening(?bool $isHappening): self
    {
        $this->isHappening = $isHappening;

        return $this;
    }

    public function getSpecialPrediction(): ?SpecialPrediction
    {
        return $this->specialPrediction;
    }

    public function setSpecialPrediction(?SpecialPrediction $specialPrediction): self
    {
        $this->specialPrediction = $specialPrediction;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRace(): ?Race
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     */
    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }


}
