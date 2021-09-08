<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarrierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarrierRepository::class)
 * @ApiResource(
 *       collectionOperations={
 *          "GET"={"path"="/transporteurs"}, "POST"={"path"="/transporteur/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/transporteur/{id}"}, "DELETE", "PATCH"={"path"="/transporteur/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"carrier_read"}
 *      }
 * )
 */
class Carrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"carrier_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"carrier_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"carrier_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"carrier_read"})
     */
    private $price;

    public function __toString()
    {
        return $this->getName() .' [br] ' . $this->getDescription() . ' [br] ' .number_format(($this->getPrice()), 2, ',',',').' €';
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
}
