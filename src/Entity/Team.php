<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @Vich\Uploadable
 */
class Team
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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Driver", mappedBy="team")
     */
    private $driver;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $raceCar;

    /**
     * @Vich\UploadableField(mapping="team_race_car", fileNameProperty="raceCar")
     * @var File
     */
    private $raceCarFile;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->driver = new ArrayCollection();
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
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getRaceCar(): ?string
    {
        return $this->raceCar;
    }

    /**
     * @param string $raceCar
     */
    public function setRaceCar(?string $raceCar): void
    {
        $this->raceCar = $raceCar;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getRaceCarFile(): ?File
    {
        return $this->raceCarFile;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $raceCar
     * @throws \Exception
     */
    public function setRaceCarFile(?File $raceCar): void
    {
        $this->raceCarFile = $raceCar;

        if($raceCar) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return Collection|Driver[]
     */
    public function getDriver(): Collection
    {
        return $this->driver;
    }

    public function addDriver(Driver $driver): self
    {
        if (!$this->driver->contains($driver)) {
            $this->driver[] = $driver;
            $driver->setTeam($this);
        }

        return $this;
    }

    public function removeDriver(Driver $driver): self
    {
        if ($this->driver->contains($driver)) {
            $this->driver->removeElement($driver);
            // set the owning side to null (unless already changed)
            if ($driver->getTeam() === $this) {
                $driver->setTeam(null);
            }
        }

        return $this;
    }
}
