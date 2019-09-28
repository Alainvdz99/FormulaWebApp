<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DriverRepository")
 * @Vich\Uploadable
 */
class Driver
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
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="drivers_avatar", fileNameProperty="avatar")
     * @var File
     */
    private $avatarFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $modalAvatar;

    /**
     * @Vich\UploadableField(mapping="drivers_modal_avatar", fileNameProperty="modalAvatar")
     * @var File
     */
    private $modalAvatarFile;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $bio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    public function __toString()
    {
        return $this->name;
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
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return File
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     * @param File $avatar
     * @throws \Exception
     */
    public function setAvatarFile(?File $avatar): void
    {
        $this->avatarFile = $avatar;

        if($avatar) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return string
     */
    public function getModalAvatar(): ?string
    {
        return $this->modalAvatar;
    }

    /**
     * @param string $modalAvatar
     */
    public function setModalAvatar(?string $modalAvatar): void
    {
        $this->modalAvatar = $modalAvatar;
    }

    /**
     * @return file
     */
    public function getModalAvatarFile(): ?File
    {
        return $this->modalAvatarFile;
    }

    /**
     * @param File $modalAvatar
     * @throws \Exception
     */
    public function setModalAvatarFile(?File $modalAvatar): void
    {
        $this->modalAvatarFile = $modalAvatar;

        if($modalAvatar) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

}
