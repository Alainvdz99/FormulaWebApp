<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalPoints = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $shortName;

    /**
     * @var RacePrediction
     * @ORM\OneToMany(targetEntity="App\Entity\RacePrediction", mappedBy="user")
     */
    private $racePredictions;

    public function __construct()
    {
        parent::__construct();
        $this->racePredictions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getTotalPoints(): int
    {
        return $this->totalPoints;
    }

    /**
     * @param int $totalPoints
     */
    public function setTotalPoints(int $totalPoints): void
    {
        $this->totalPoints = $totalPoints;
    }

    /**
     * @return RacePrediction
     */
    public function getRacePredictions(): RacePrediction
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
     * @return string|null
     */
    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }

}
