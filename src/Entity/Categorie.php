<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo; // Gere le slug
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/categories"}, "POST"={"path"="/categorie/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/categorie/{id}"}, "DELETE", "PATCH"={"path"="/categorie/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"categorie_read"}
 *      }
 * )
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categorie_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categorie_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categorie_read"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="categorie_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity=Jeuxvideo::class, inversedBy="categories")
     */
    private $game;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime $created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"categorie_read"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"categorie_read"})
    */
    private $updatedAt;

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
        }

        return $this;
    }

    public function removeGame(Jeuxvideo $game): self
    {
        $this->game->removeElement($game);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): ?\DateTimeInterface
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setSlug(string $slug): string
    {
        $this->slug = $slug;
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
