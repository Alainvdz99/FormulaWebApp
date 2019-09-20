<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialPredictionRepository")
 */
class SpecialPrediction
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prediction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race")
     */
    private $race;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isHappened;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrediction(): ?string
    {
        return $this->prediction;
    }

    public function setPrediction(string $prediction): self
    {
        $this->prediction = $prediction;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getIsHappened(): ?bool
    {
        return $this->isHappened;
    }

    public function setIsHappened(bool $isHappened): self
    {
        $this->isHappened = $isHappened;

        return $this;
    }
}
