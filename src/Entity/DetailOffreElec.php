<?php

namespace App\Entity;

use App\Repository\DetailOffreElecRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailOffreElecRepository::class)
 */
class DetailOffreElec
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prAbonnementParAn;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prPte;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prHPH;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prHCH;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prHPE;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prHCE;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $budgetHTT;

    /**
     * @ORM\ManyToOne(targetEntity=OffreElectricite::class, inversedBy="detailOffreElecs")
     */
    private $offre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrAbonnementParAn(): ?string
    {
        return $this->prAbonnementParAn;
    }

    public function setPrAbonnementParAn(?string $prAbonnementParAn): self
    {
        $this->prAbonnementParAn = $prAbonnementParAn;

        return $this;
    }

    public function getPrPte(): ?string
    {
        return $this->prPte;
    }

    public function setPrPte(?string $prPte): self
    {
        $this->prPte = $prPte;

        return $this;
    }

    public function getPrHPH(): ?string
    {
        return $this->prHPH;
    }

    public function setPrHPH(?string $prHPH): self
    {
        $this->prHPH = $prHPH;

        return $this;
    }

    public function getPrHCH(): ?string
    {
        return $this->prHCH;
    }

    public function setPrHCH(?string $prHCH): self
    {
        $this->prHCH = $prHCH;

        return $this;
    }

    public function getPrHPE(): ?string
    {
        return $this->prHPE;
    }

    public function setPrHPE(?string $prHPE): self
    {
        $this->prHPE = $prHPE;

        return $this;
    }

    public function getPrHCE(): ?string
    {
        return $this->prHCE;
    }

    public function setPrHCE(?string $prHCE): self
    {
        $this->prHCE = $prHCE;

        return $this;
    }

    public function getBudgetHTT(): ?string
    {
        return $this->budgetHTT;
    }

    public function setBudgetHTT(?string $budgetHTT): self
    {
        $this->budgetHTT = $budgetHTT;

        return $this;
    }

    public function getOffre(): ?OffreElectricite
    {
        return $this->offre;
    }

    public function setOffre(?OffreElectricite $offre): self
    {
        $this->offre = $offre;

        return $this;
    }
}
