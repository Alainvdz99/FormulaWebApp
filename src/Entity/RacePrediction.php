<?php

namespace App\Entity;

use App\Interfaces\PredictionInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RacePredictionRepository")
 *  * @ORM\Table(name="race_prediction",
 *     uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_race_prediction", columns={"race_id", "user_id"})
 *     })
 */
class RacePrediction implements PredictionInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $fastestTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fastestDriverInQuali;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fastestDriverInRace;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $firstPlaceDriver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $secondPlaceDriver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $thirdPlaceDriver;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tierMax;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="racePredictions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race", inversedBy="racePredictions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isEnabled = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFastestTime()
    {
        return $this->fastestTime;
    }

    /**
     * @param mixed $fastestTime
     */
    public function setFastestTime($fastestTime): void
    {
        $this->fastestTime = $fastestTime;
    }

    public function getFastestDriverInQuali(): ?Driver
    {
        return $this->fastestDriverInQuali;
    }

    public function setFastestDriverInQuali(?Driver $fastestDriverInQuali): self
    {
        $this->fastestDriverInQuali = $fastestDriverInQuali;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFastestDriverInRace()
    {
        return $this->fastestDriverInRace;
    }

    /**
     * @param mixed $fastestDriverInRace
     */
    public function setFastestDriverInRace($fastestDriverInRace): void
    {
        $this->fastestDriverInRace = $fastestDriverInRace;
    }

    /**
     * @return mixed
     */
    public function getFirstPlaceDriver()
    {
        return $this->firstPlaceDriver;
    }

    /**
     * @param mixed $firstPlaceDriver
     */
    public function setFirstPlaceDriver($firstPlaceDriver): void
    {
        $this->firstPlaceDriver = $firstPlaceDriver;
    }

    /**
     * @return mixed
     */
    public function getSecondPlaceDriver()
    {
        return $this->secondPlaceDriver;
    }

    /**
     * @param mixed $secondPlaceDriver
     */
    public function setSecondPlaceDriver($secondPlaceDriver): void
    {
        $this->secondPlaceDriver = $secondPlaceDriver;
    }

    /**
     * @return mixed
     */
    public function getThirdPlaceDriver()
    {
        return $this->thirdPlaceDriver;
    }

    /**
     * @param $thirdPlaceDriver
     */
    public function setThirdPlaceDriver($thirdPlaceDriver): void
    {
        $this->thirdPlaceDriver = $thirdPlaceDriver;
    }

    /**
     * @return string
     */
    public function getTierMax(): ?string
    {
        return $this->tierMax;
    }

    /**
     * @param string $tierMax
     */
    public function setTierMax(string $tierMax): void
    {
        $this->tierMax = $tierMax;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     */
    public function setRace($race): void
    {
        $this->race = $race;
    }

    /**
     * @return bool
     */
    public function getIsEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     */
    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

}
