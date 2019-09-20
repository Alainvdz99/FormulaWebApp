<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SpecialPredictionInput
{
    /** @var ArrayCollection */
    private $specialPredictionVotes;

    public function __construct()
    {
        $this->specialPredictionVotes = new ArrayCollection();
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
}
