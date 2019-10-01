<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SpecialPredictionInput
{
    /** @var ArrayCollection */
    private $specialPredictionVotes;

    /** @var ArrayCollection */
    private $specialPredictionResults;

    public function __construct()
    {
        $this->specialPredictionVotes = new ArrayCollection();
        $this->specialPredictionResults = new ArrayCollection();
    }


    public function getSpecialPredictionVotes()
    {
        return $this->specialPredictionVotes;
    }

    public function addSpecialPredictionVote($specialPredictionVotes): self
    {
        if (!$this->specialPredictionVotes->contains($specialPredictionVotes)) {
            $this->specialPredictionVotes[] = $specialPredictionVotes;
        }

        return $this;
    }

    public function removeSpecialPredictionVote($specialPredictionVotes): self
    {
        if ($this->specialPredictionVotes->contains($specialPredictionVotes)) {
            $this->specialPredictionVotes->removeElement($specialPredictionVotes);

        }

        return $this;
    }

    public function getSpecialPredictionResults()
    {
        return $this->specialPredictionResults;
    }

    public function addSpecialPredictionResult($specialPredictionResult): self
    {
        if (!$this->specialPredictionResults->contains($specialPredictionResult)) {
            $this->specialPredictionResults[] = $specialPredictionResult;
        }

        return $this;
    }

    public function removeSpecialPredictionResult($specialPredictionResult): self
    {
        if ($this->specialPredictionResults->contains($specialPredictionResult)) {
            $this->specialPredictionResults->removeElement($specialPredictionResult);

        }

        return $this;
    }
}
