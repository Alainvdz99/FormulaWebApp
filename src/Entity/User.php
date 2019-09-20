<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string")
     */
    private $avatar;


    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalPoints = 0;

    /**
     * @var \App\Entity\RacePrediction
     * @ORM\OneToMany(targetEntity="App\Entity\RacePrediction", mappedBy="user")
     */
    private $racePredictions;

    public function __construct()
    {
        $this->racePredictions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
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

}
