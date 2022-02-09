<?php
declare(strict_types=1);
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UploadCsvRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass=UploadCsvRepository::class)
 * 
 * @ApiResource(
 *      collectionOperations={
 *          "GET"={"path"="/csv"}, "POST"={"path"="/csv"},
 *          
 *      },
 *      normalizationContext={
 *          "groups"={"csv_read"}
 *      },
 *      denormalizationContext={
 *          "groups"={"csv_write"}
 *      }
 * )
 */
class UploadCsv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("csv_read", "csv_write")
     */
    private $rank;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("csv_read", "csv_write")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("csv_read", "csv_write")
     */
    private $platform;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("csv_read", "csv_write")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("csv_read", "csv_write")
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("csv_read", "csv_write")
     */
    private $publisher;

    /**
     * @ORM\Column(type="float")
     * @Groups("csv_read", "csv_write")
     */
    private $naSales;

    /**
     * @ORM\Column(type="float")
     * @Groups("csv_read", "csv_write")
     */
    private $euSales;

    /**
     * @ORM\Column(type="float")
     * @Groups("csv_read", "csv_write")
     */
    private $jpSales;

    /**
     * @ORM\Column(type="float")
     * @Groups("csv_read", "csv_write")
     */
    private $otherSales;

    /**
     * @ORM\Column(type="float")
     * @Groups("csv_read", "csv_write")
     */
    private $globalSales;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
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

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getNaSales(): ?float
    {
        return $this->naSales;
    }

    public function setNaSales(float $naSales): self
    {
        $this->naSales = $naSales;

        return $this;
    }

    public function getEuSales(): ?float
    {
        return $this->euSales;
    }

    public function setEuSales(float $euSales): self
    {
        $this->euSales = $euSales;

        return $this;
    }

    public function getJpSales(): ?float
    {
        return $this->jpSales;
    }

    public function setJpSales(float $jpSales): self
    {
        $this->jpSales = $jpSales;

        return $this;
    }

    public function getOtherSales(): ?float
    {
        return $this->otherSales;
    }

    public function setOtherSales(float $otherSales): self
    {
        $this->otherSales = $otherSales;

        return $this;
    }

    public function getGlobalSales(): ?float
    {
        return $this->globalSales;
    }

    public function setGlobalSales(float $globalSales): self
    {
        $this->globalSales = $globalSales;

        return $this;
    }
}
