<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\JeuxvideoRepository;
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
 * @ORM\Entity(repositoryClass=JeuxvideoRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/jeuxvideos"}, "POST"={"path"="/jeuxvideo/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/jeuxvideo/{id}"}, "DELETE", "PATCH"={"path"="/jeuxvideo/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"jeux_read"}
 *      }
 * )
 */
class Jeuxvideo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"jeux_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     * @Groups({"jeux_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"jeux_read"})
     */
    private $coverImage;

    /**
     * @Vich\UploadableField(mapping="jeuxvideo_images", fileNameProperty="coverImage")
     *
     * @var File
     */
    private $imageFile;

    

    /**
     * @ORM\Column(type="float")
     * @Groups({"jeux_read"})
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Groups({"jeux_read"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, mappedBy="game")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="game", orphanRemoval=true)
     */
    private $comments;

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
     * @Groups({"jeux_read"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"jeux_read"})
    */
    private $updatedAt;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addGame($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setGame($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getGame() === $this) {
                $comment->setGame(null);
            }
        }

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

    // public function getImageSize(): ?int
    // {
    //     return $this->imageSize;
    // }

    // public function setImageSize(?int $imageSize): void
    // {
    //     $this->imageSize = $imageSize;
    // }
}
