<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderDetailsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderDetailsRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/factures"}, "POST"={"path"="/facture/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/facture/{id}"}, "DELETE", "PATCH"={"path"="/facture/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"order_details_read"}
 *      }
 * )
 */
class OrderDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"order_details_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"order_details_read"})
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"order_details_read"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     * @Groups({"order_details_read"})
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Groups({"order_details_read"})
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $myOrder;

    public function __toString()
    {
        return $this->getProduct() . ' ' . \number_format(($this->getPrice() / 100), 2, ',', '.') . ' € ';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): self
    {
        $this->myOrder = $myOrder;

        return $this;
    }
}
