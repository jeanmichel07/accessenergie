<?php

namespace App\Entity;

use App\Repository\PerimetreElectriciteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerimetreElectriciteRepository::class)
 */
class PerimetreElectricite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="perimetreElectricites")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFourniture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PDL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomPtLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segmentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $HPH;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $HCH;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $HPE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $HCE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDateFourniture()
    {
        return $this->dateFourniture;
    }

    public function setDateFourniture($dateFourniture): self
    {
        $this->dateFourniture = $dateFourniture;

        return $this;
    }

    public function getPDL(): ?string
    {
        return $this->PDL;
    }

    public function setPDL(?string $PDL): self
    {
        $this->PDL = $PDL;

        return $this;
    }

    public function getNomPtLivraison(): ?string
    {
        return $this->nomPtLivraison;
    }

    public function setNomPtLivraison(?string $nomPtLivraison): self
    {
        $this->nomPtLivraison = $nomPtLivraison;

        return $this;
    }

    public function getSegmentation(): ?string
    {
        return $this->segmentation;
    }

    public function setSegmentation(?string $segmentation): self
    {
        $this->segmentation = $segmentation;

        return $this;
    }

    public function getPte(): ?string
    {
        return $this->pte;
    }

    public function setPte(?string $pte): self
    {
        $this->pte = $pte;

        return $this;
    }

    public function getHPH(): ?string
    {
        return $this->HPH;
    }

    public function setHPH(?string $HPH): self
    {
        $this->HPH = $HPH;

        return $this;
    }

    public function getHCH(): ?string
    {
        return $this->HCH;
    }

    public function setHCH(string $HCH): self
    {
        $this->HCH = $HCH;

        return $this;
    }

    public function getHPE(): ?string
    {
        return $this->HPE;
    }

    public function setHPE(?string $HPE): self
    {
        $this->HPE = $HPE;

        return $this;
    }

    public function getHCE(): ?string
    {
        return $this->HCE;
    }

    public function setHCE(?string $HCE): self
    {
        $this->HCE = $HCE;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $total): self
    {
        $this->total = $total;

        return $this;
    }
}
