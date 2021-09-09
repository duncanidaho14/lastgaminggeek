<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AddressRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/adresses"}, "POST"={"path"="/adresse/{id}"},
 *          
 *      },
 *      itemOperations={
 *          "GET"={"path"="/adresse/{id}"}, "DELETE", "PATCH"={"path"="/adresse/{id}"} 
 *      },
 *      normalizationContext={
 *          "groups"={"address_read"}
 *      }
 * )
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"address_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de l'adresse est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom de l'adresse doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le nom de l'adresse doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre prenom doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Votre prenom doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre nom doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Votre nom doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=3, minMessage="Le nom de votre entreprise doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le nom de votre entreprise doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="L'adresse doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="L'adresse doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Le code postal de l'adresse doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le code postal de l'adresse doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="La ville de l'adresse doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="La ville de l'adresse doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Le pays de l'adresse doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Le pays de l'adresse doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre numéro de téléphone doit faire entre 3 et 255 caracteres",
     *                max=255, maxMessage="Votre numéro de téléphone doit faire moins de 255 caracteres")
     * @Groups({"address_read"})
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"address_read"})
     */
    private $user;

    public function __toString()
    {
        return $this->getName() . ' [br] ' . $this->getAddress() . ' [br] ' . $this->getCity() . ' [br] ' . $this->getCountry();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
}
