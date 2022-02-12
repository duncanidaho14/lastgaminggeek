<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo; // Gere le slug
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/commentaires"}, "POST"={"path"="/commentaire/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/commentaire/{id}"}, "DELETE", "PATCH"={"path"="/commentaire/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"comment_read"}
 *      }
 * )
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comment_read"})
     */
    private $id;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le commentaire est obligatoire")
     * @Assert\Length(min=3, minMessage="Le commentaire doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le commentaire doit faire moins de 255 caracteres")
     * @Groups({"comment_read"})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment_read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Jeuxvideo::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comment_read"})
     */
    private $game;

    /**
     * @ORM\Column(type="string", length=170)
     * @Assert\NotBlank(message="Le titre du commentaire est obligatoire")
     * @Assert\Length(min=3, minMessage="Le titre du commentaire doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le titre du commentaire doit faire moins de 255 caracteres")
     * @Groups({"comment_read"})
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime $created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"comment_read"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"comment_read"})
    */
    private $updatedAt;

    public function __toString()
    {
        return $this->getTitle();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getGame(): ?Jeuxvideo
    {
        return $this->game;
    }

    public function setGame(?Jeuxvideo $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
}
