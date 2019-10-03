<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialPredictionResultRepository")
 */
class SpecialPredictionResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SpecialPrediction", cascade={"persist", "remove"})
     */
    private $specialPrediction;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $happened;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isHappened(): ?bool
    {
        return $this->happened;
    }

    public function setHappened(?bool $happened): self
    {
        $this->happened = $happened;

        return $this;
    }
}
