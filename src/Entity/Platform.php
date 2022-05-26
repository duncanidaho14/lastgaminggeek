<?php

namespace App\Entity;

use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatformRepository::class)
 * @Vich\Uploadable
 */
class Platform
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="platform_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=Jeuxvideo::class, mappedBy="platform")
     */
    private $game;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Jeuxvideo[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Jeuxvideo $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setPlatform($this);
        }

        return $this;
    }

    public function removeGame(Jeuxvideo $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getPlatform() === $this) {
                $game->setPlatform(null);
            }
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Undocumented function
     *
     * @param File|null $imageFile
     * 
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        // Vérifie s'il y a un changement de propriété de l'imageFile
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTime();
        }
    }
}
